<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GroupClassResource\Pages;
use App\Filament\Resources\GroupClassResource\RelationManagers;
use App\Models\Classes\GroupClass;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Colors\Color;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class GroupClassResource extends Resource
{
    protected static ?string $model = GroupClass::class;

    protected static ?int $navigationSort = 2;
    protected static ?string $navigationLabel = 'Kelas Belajar';
    protected static ?string $modelLabel = 'Kelas Belajar';
    protected static ?string $navigationGroup = 'Kelas';
    protected static ?string $navigationIcon = 'heroicon-o-bookmark-square';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()->schema([
                    TextInput::make('title')
                        ->string()
                        ->required()
                        ->autofocus()
                        ->label('Judul Kelas')
                        ->placeholder('Judul Kelas'),
                    TextInput::make('price')
                        ->label('Harga Materi')
                        ->placeholder('Masukkan Harga Materi')
                        ->numeric()
                        ->prefix('Rp ')
                        ->required(),
                    Select::make('grade_id')
                        ->label('Jenjang Kelas')
                        ->placeholder('Pilih Jenjang Kelas')
                        ->relationship('grade', 'name')
                        ->required(),
                    Select::make('subject_id')
                        ->label('Mata Pelajaran')
                        ->placeholder('Pilih Mata Pelajaran')
                        ->relationship('subject', 'name')
                        ->required(),
                    Select::make('learning_method_id')
                        ->label('Metode Pembelajaran')
                        ->placeholder('Pilih Metode Pembelajaran')
                        ->relationship('learningMethod', 'name')
                        ->required(),
                    RichEditor::make('description')
                        ->label('Deskripsi Kelas')
                        ->placeholder('Masukkan Deskripsi Kelas')
                        ->disableToolbarButtons([
                            'attachFiles',
                        ])
                        ->hiddenOn(['view'])
                        ->hint('Masukkan Deskripsi Kelas')
                        ->required(),
                    RichEditor::make('additional_info')
                        ->label('Informasi Tambahan')
                        ->placeholder('Masukkan Informasi Tambahan')
                        ->disableToolbarButtons([
                            'attachFiles',
                        ])
                        ->hiddenOn(['view'])
                        ->hint('Masukkan Informasi Tambahan'),
                    Toggle::make('status')
                        ->label('Status Materi')
                        ->hiddenOn(['create'])
                        ->hint('Status Materi')
                        ->default(1)
                        ->required(),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('No')
                    ->rowIndex(),
                TextColumn::make('title')
                    ->label('Judul Kelas')
                    ->limit(20)
                    ->searchable()
                    ->sortable(),
                TextColumn::make('grade.name')
                    ->label('Jenjang Kelas'),
                TextColumn::make('subject.name')
                    ->label('Mata Pelajaran'),
                TextColumn::make('learningMethod.name')
                    ->badge()
                    ->color(Color::Blue)
                    ->label('Metode Pembelajaran'),
                TextColumn::make('price')
                    ->label('Harga Materi')
                    ->money('idr', true)
                    ->searchable()
                    ->sortable(),
                TextColumn::make('schedule_count')
                    ->counts('schedules')
                    ->default(0)
                    ->label('Jumlah Jadwal'),
                TextColumn::make('status')
                    ->label('Status Materi')
                    ->badge(),
            ])
            ->filters([
                TernaryFilter::make('status')
                    ->options([
                        '1' => 'Aktif',
                        '0' => 'Tidak Aktif',
                    ])
                    ->label('Status'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\SchedulesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGroupClasses::route('/'),
            'create' => Pages\CreateGroupClass::route('/create'),
            'edit' => Pages\EditGroupClass::route('/{record}/edit'),
        ];
    }
}

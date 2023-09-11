<?php

namespace App\Filament\Resources;

use App\Entities\PrivateClassEntities;
use App\Filament\Resources\PrivateClassResource\Pages;
use App\Filament\Resources\PrivateClassResource\RelationManagers;
use App\Models\Classes\PrivateClass;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Support\Colors\Color;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PrivateClassResource extends Resource
{
    protected static ?string $model = PrivateClass::class;

    protected static ?int $navigationSort = 2;
    protected static ?string $navigationLabel = 'Kelas Privat';
    protected static ?string $modelLabel = 'Kelas Privat';
    protected static ?string $navigationGroup = 'Kelas';
    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informasi Kelas')
                    ->description('Bagian ini berisi informasi umum tentang kelas privat')
                    ->schema([
                        Select::make('mentor_id')
                            ->searchable()
                            ->relationship('mentor', 'full_name')
                            ->required()
                            ->label('Nama Mentor')
                            ->placeholder('Pilih Mentor'),
                        Select::make('subject_id')
                            ->searchable()
                            ->relationship('subject', 'name')
                            ->required()
                            ->label('Mata Pelajaran')
                            ->placeholder('Pilih Mata Pelajaran'),
                        Select::make('grade_id')
                            ->relationship('grade', 'name')
                            ->required()
                            ->label('Jenjang Kelas')
                            ->placeholder('Pilih Jenjang Kelas'),
                        Select::make('learning_method_id')
                            ->relationship('learningMethod', 'name')
                            ->required()
                            ->label('Metode Pembelajaran')
                            ->placeholder('Pilih Metode Pembelajaran'),
                        TextInput::make('price')
                            ->label('Harga Materi')
                            ->placeholder('Masukkan Harga Materi')
                            ->numeric()
                            ->prefix('Rp ')
                            ->required(),
                        TextInput::make('address')
                            ->label('Alamat Kelas')
                            ->placeholder('Masukkan Alamat Kelas'),
                        RichEditor::make('description')
                            ->label('Deskripsi Kelas')
                            ->placeholder('Masukkan Deskripsi Kelas')
                            ->disableToolbarButtons([
                                'attachFiles',
                            ])
                            ->hiddenOn(['view'])
                            ->hint('Contoh: Kelas ini akan membahas tentang ...')
                            ->required(),
                        Radio::make('status')
                            ->live()
                            ->hiddenOn(['create'])
                            ->hidden(fn(Get $get) => $get('status') !==
                                PrivateClassEntities::STATUS_PURCHASED)
                            ->options(PrivateClassEntities::STATUS)
                            ->required()
                            ->label('Status'),
                    ])

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('No')
                    ->rowIndex(),
                TextColumn::make('mentor.full_name')
                    ->label('Nama Mentor')
                    ->limit(30)
                    ->searchable()
                    ->sortable(),
                TextColumn::make('subject.name')
                    ->label('Mata Pelajaran'),
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
                    ->badge(),
            ])
            ->filters([
                //
            ])
            ->actions([
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
            RelationManagers\SchedulesRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPrivateClasses::route('/'),
            'create' => Pages\CreatePrivateClass::route('/create'),
            'edit' => Pages\EditPrivateClass::route('/{record}/edit'),
        ];
    }
}

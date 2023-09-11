<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MaterialResource\Pages;
use App\Filament\Resources\MaterialResource\RelationManagers;
use App\Models\Materials\Material;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class MaterialResource extends Resource
{
    protected static ?string $model = Material::class;
    protected static ?int $navigationSort = 2;
    protected static ?string $navigationLabel = 'Materi';
    protected static ?string $modelLabel = 'Materi';
    protected static ?string $navigationGroup = 'Materi';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()->schema([
                    FileUpload::make('cover_image')
                        ->disk('public')
                        ->directory('materials')
                        ->visibility('private')
                        ->label('Gambar Materi')
                        ->hint('Ukuran gambar yang diperbolehkan adalah lebih kecil dari 2MB')
                        ->acceptedFileTypes(['image/*'])
                        ->maxSize(2 * 1024 * 1024)
                        ->downloadable()
                        ->image()
                        ->required(),
                    TextInput::make('title')
                        ->label('Judul Materi')
                        ->placeholder('Masukkan Judul Materi')
                        ->autofocus()
                        ->required(),
                    Select::make('grade_id')
                        ->label('Jenjang Kelas')
                        ->placeholder('Pilih Jenjang Kelas')
                        ->relationship('grade', 'name')
                        ->required(),
                    Grid::make(2)->schema([
                        TextInput::make('price')
                            ->label('Harga Materi')
                            ->placeholder('Masukkan Harga Materi')
                            ->numeric()
                            ->prefix('Rp ')
                            ->required(),
                        TextInput::make('total_page')
                            ->label('Total Halaman')
                            ->placeholder('Masukkan Jumlah Total Halaman')
                            ->required(),
                    ]),
                    RichEditor::make('description')
                        ->label('Deskripsi Materi')
                        ->placeholder('Masukkan Deskripsi Materi')
                        ->disableToolbarButtons([
                            'attachFiles',
                        ])
                        ->hiddenOn(['view'])
                        ->hint('Masukkan Deskripsi Materi')
                        ->required(),
                    RichEditor::make('benefits')
                        ->label('Manfaat Materi')
                        ->disableToolbarButtons([
                            'attachFiles',
                        ])
                        ->hiddenOn(['view'])
                        ->placeholder('Masukkan Tentang Manfaat Materi'),
                    FileUpload::make('preview_file')
                        ->disk('public')
                        ->directory('materials')
                        ->visibility('private')
                        ->label('File Preview Materi')
                        ->hint('Ukuran file yang diperbolehkan adalah lebih kecil dari  5MB')
                        ->acceptedFileTypes(['application/pdf'])
                        ->downloadable()
                        ->maxSize(5 * 1024 * 1024)
                        ->required(),
                    FileUpload::make('source_file')
                        ->disk('public')
                        ->directory('materials')
                        ->visibility('private')
                        ->label('File Materi')
                        ->acceptedFileTypes(['application/pdf'])
                        ->downloadable()
                        ->required(),
                    Toggle::make('status')
                        ->label('Status Materi')
                        ->hiddenOn(['create'])
                        ->hint('Status Materi')
                        ->default(1)
                        ->required(),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('title')
                    ->label('Judul Materi')
                    ->limit(20)
                    ->searchable()
                    ->sortable(),
                TextColumn::make('grade.name')
                    ->label('Jenjang Kelas'),
                TextColumn::make('price')
                    ->label('Harga Materi')
                    ->money('idr', true)
                    ->searchable()
                    ->sortable(),
                TextColumn::make('status')
                    ->badge(),
                TextColumn::make('created_at')
                    ->label('Dibuat Pada')
                    ->date('d F Y')
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                TernaryFilter::make('status')
                    ->label('Status Materi')
                    ->trueLabel('Aktif')
                    ->falseLabel('Tidak Aktif'),
                Filter::make('created_at')
                    ->form([
                        DatePicker::make('created_from'),
                        DatePicker::make('created_until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn(Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn(Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    })
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMaterials::route('/'),
            'create' => Pages\CreateMaterial::route('/create'),
            'edit' => Pages\EditMaterial::route('/{record}/edit'),
        ];
    }
}

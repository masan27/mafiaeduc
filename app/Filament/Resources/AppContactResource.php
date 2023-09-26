<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AppContactResource\Pages;
use App\Filament\Resources\AppContactResource\RelationManagers;
use App\Models\Contacts\AppContact;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AppContactResource extends Resource
{
    protected static ?string $model = AppContact::class;

    protected static ?int $navigationSort = 8;
    protected static ?string $navigationGroup = 'Pengaturan';
    protected static ?string $navigationIcon = 'heroicon-o-phone';
    protected static ?string $modelLabel = 'Kontak Aplikasi';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->autofocus()
                            ->required()
                            ->maxLength(255)
                            ->label('Nama Kontak')
                            ->placeholder('Masukkan nama kontak'),
                        Forms\Components\TextInput::make('phone')
                            ->required()
                            ->numeric()
                            ->maxLength(255)
                            ->label('Nomor Telepon')
                            ->placeholder('Masukkan nomor telepon'),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('index')
                    ->label('No')
                    ->rowIndex(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Kontak')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('phone')
                    ->label('Nomor Telepon')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal Dibuat')
                    ->date('d F Y')
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make()->hidden(function () {
                    return AppContact::count() >= 1;
                }),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageAppContacts::route('/'),
        ];
    }
}

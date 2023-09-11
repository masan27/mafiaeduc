<?php

namespace App\Filament\Resources;

use App\enums\StatusEnum;
use App\Filament\Resources\AdminResource\Pages;
use App\Filament\Resources\AdminResource\RelationManagers;
use App\Models\Admins\Admin;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Hash;

class AdminResource extends Resource
{
    protected static ?string $model = Admin::class;
    protected static ?int $navigationSort = 3;
    protected static ?string $navigationLabel = 'Admin';
    protected static ?string $modelLabel = 'Admin';
    protected static ?string $navigationGroup = 'Staff';
    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Keterangan')
                    ->description('Berisi informasi mengenai admin')
                    ->schema([
                        TextInput::make('name')
                            ->string()
                            ->maxLength(50)
                            ->autofocus()
                            ->required()
                            ->placeholder('Masukkan nama lengkap'),
                    ]),
                Section::make('Akun')
                    ->description('Berisi informasi mengenai akun admin')
                    ->schema([
                        TextInput::make('email')
                            ->email()
                            ->required()
                            ->placeholder('Masukkan email'),
                        TextInput::make('password')
                            ->password()
                            ->confirmed()
                            ->required(fn(string $context): bool => $context === 'create')
                            ->placeholder('Masukkan password')
                            ->dehydrateStateUsing(fn($state) => Hash::make($state))
                            ->dehydrated(fn($state) => filled($state))
                            ->required(fn(string $context): bool => $context === 'create'),
                        TextInput::make('password_confirmation')
                            ->password()
                            ->required(fn(string $context): bool => $context === 'create')
                            ->same('password')
                            ->placeholder('Masukkan konfirmasi password'),
                        Toggle::make('status')
                            ->label('Aktif')
                            ->hiddenOn('create'),
                    ]),
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
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Registered At')
                    ->date('d F Y')
                    ->sortable(),
                ToggleColumn::make('status')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options(StatusEnum::class),
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
            'index' => Pages\ListAdmins::route('/'),
            'create' => Pages\CreateAdmin::route('/create'),
            'edit' => Pages\EditAdmin::route('/{record}/edit'),
        ];
    }
}

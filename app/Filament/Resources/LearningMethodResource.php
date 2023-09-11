<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LearningMethodResource\Pages;
use App\Filament\Resources\LearningMethodResource\RelationManagers;
use App\Models\LearningMethods\LearningMethod;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class LearningMethodResource extends Resource
{
    protected static ?string $model = LearningMethod::class;
    protected static ?int $navigationSort = 5;

    protected static ?string $navigationGroup = 'Pengaturan';
    protected static ?string $navigationIcon = 'heroicon-o-globe-alt';
    protected static ?string $navigationLabel = 'Metode Pembelajaran';
    protected static ?string $modelLabel = 'Metode Pembelajaran';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()->schema([
                    TextInput::make('name')
                        ->required()
                        ->string()
                        ->placeholder('Nama Metode Pembelajaran'),
                    TextInput::make('description')
                        ->required()
                        ->string()
                        ->placeholder('Tentang Metode Pembelajaran'),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('description')
                    ->limit(20),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created At')
                    ->date('d F Y')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
//                Tables\Actions\EditAction::make(),
//                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
//                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
//                Tables\Actions\CreateAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageLearningMethods::route('/'),
        ];
    }
}

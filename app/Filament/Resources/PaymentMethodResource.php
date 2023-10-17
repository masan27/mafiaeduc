<?php

namespace App\Filament\Resources;

use App\Entities\PaymentMethodEntities;
use App\Filament\Resources\PaymentMethodResource\Pages;
use App\Filament\Resources\PaymentMethodResource\RelationManagers;
use App\Models\Payments\PaymentMethod;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Support\Colors\Color;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;

//use Illuminate\Database\Eloquent\Builder;
//use Illuminate\Database\Eloquent\SoftDeletingScope;

class PaymentMethodResource extends Resource
{
    protected static ?string $model = PaymentMethod::class;
    protected static ?int $navigationSort = 5;

    protected static ?string $navigationLabel = 'Metode Pembayaran';
    protected static ?string $modelLabel = 'Metode Pembayaran';
    protected static ?string $navigationGroup = 'Pengaturan';
    protected static ?string $navigationIcon = 'heroicon-o-credit-card';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()->schema([
                    Grid::make()->schema([
                        TextInput::make('name')
                            ->required()
                            ->autofocus()
                            ->string()
                            ->live()
                            ->afterStateUpdated(fn(Set $set, ?string $state) => $set('code', Str::slug
                            ($state)))
                            ->placeholder('Nama Metode Pembayaran'),
                        TextInput::make('code')
                            ->required()
                            ->string()
                            ->placeholder('Nama Metode Pembayaran'),
                    ]),
                    Select::make('type')
                        ->required()
                        ->default(PaymentMethodEntities::PAYMENT_METHOD_TYPE_BANK)
                        ->options([
                            PaymentMethodEntities::PAYMENT_METHOD_TYPE_BANK => 'Bank',
                        ]),
                    TextInput::make('description')
                        ->string()
                        ->placeholder('Tentang Metode Pembayaran'),
                    TextInput::make('fee')
                        ->required()
                        ->numeric()
                        ->placeholder('Biaya Proses'),
                    TextInput::make('account_number')
                        ->required()
                        ->numeric()
                        ->placeholder('Nomor Rekening Bank'),
                    Toggle::make('status')
                        ->hiddenOn(['create']),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('No')
                    ->rowIndex(),
                TextColumn::make('name')
                    ->label('Nama Metode Pembayaran')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('description')
                    ->wrap()
                    ->limit(20),
                TextColumn::make('fee')
                    ->money('idr', true)
                    ->searchable()
                    ->sortable(),
                TextColumn::make('type')
                    ->label('Tipe')
                    ->badge()
                    ->color(Color::Blue)
                    ->searchable()
                    ->sortable(),
                TextColumn::make('status')
                    ->badge()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
//                Tables\Actions\ForceDeleteAction::make(),
//                Tables\Actions\RestoreAction::make(),
//                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
//                Tables\Actions\BulkActionGroup::make([
//                    Tables\Actions\ForceDeleteBulkAction::make(),
//                    Tables\Actions\RestoreBulkAction::make(),
//                    Tables\Actions\DeleteBulkAction::make(),
//                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManagePaymentMethods::route('/'),
        ];
    }

//    public static function getEloquentQuery(): Builder
//    {
//        return parent::getEloquentQuery()
//            ->withoutGlobalScopes([
//                SoftDeletingScope::class,
//            ]);
//    }
}

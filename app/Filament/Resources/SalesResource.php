<?php

namespace App\Filament\Resources;

use App\Entities\SalesEntities;
use App\Filament\Resources\SalesResource\Pages;
use App\Filament\Resources\SalesResource\RelationManagers;
use App\Models\Sales\Sales;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Colors\Color;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SalesResource extends Resource
{
    protected static ?string $model = Sales::class;
    protected static ?int $navigationSort = 4;
    protected static ?string $navigationLabel = 'Sales';
    protected static ?string $modelLabel = 'Sales';
    protected static ?string $navigationGroup = 'Transaksi';

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make()
                    ->columns(3)
                    ->schema([
                        Section::make('Informasi Pesanan')
                            ->description('Berisi informasi pesanan yang dibeli')
                            ->columnSpan(2)
                            ->disabled()
                            ->schema([
                                TextInput::make('id')
                                    ->label('Sales ID')
                                    ->string(),
                                DatePicker::make('sales_date')
                                    ->label('Tanggal Pembelian')
                                    ->disabled(),
                                DatePicker::make('confirm_date')
                                    ->label('Tanggal Konfirmasi')
                                    ->helperText('Tanggal pembelian akan diisi secara otomatis ketika konfirmasi dilakukan')
                                    ->disabled(),
                                DatePicker::make('payment_date')
                                    ->label('Tanggal Pembayaran')
                                    ->helperText('Tanggal pembayaran akan diisi secara otomatis ketika pembayaran dilakukan')
                                    ->disabled(),
//                                Grid::make()
//                                    ->relationship('status')
//                                    ->schema([
//                                        TextEntry::make('name')
//                                            ->label('Status')
//                                    ])
//                                    ->color(fn(string $state): string => match ($state) {
//                                        SalesEntities::SALES_STATUS_NOT_PAID_TEXT => 'gray',
//                                        SalesEntities::SALES_STATUS_PROCESSING_TEXT => 'warning',
//                                        SalesEntities::SALES_STATUS_PAID_TEXT => 'success',
//                                        SalesEntities::SALES_STATUS_EXPIRED_TEXT => 'danger',
//                                        SalesEntities::SALES_STATUS_CANCELLED_TEXT => 'danger',
//                                        SalesEntities::SALES_STATUS_FAILED_TEXT => 'danger',
//                                        default => 'gray',
//                                    })
//                                    ->badge(),
                            ]),
                        Section::make('Informasi Pembeli')
                            ->description('Berisi informasi kostumer yang melakukan pembelian')
                            ->disabled()
                            ->columnSpan(1)
                            ->relationship('user')
                            ->schema([
                                Group::make()
                                    ->relationship('detail')
                                    ->schema([
                                        TextInput::make('full_name')
                                            ->label('Nama Pembeli'),
                                        TextInput::make('phone')
                                            ->label('No. Hp'),
                                        TextInput::make('address')
                                            ->label('Alamat'),
                                        TextInput::make('school_origin')
                                            ->label('Asal Sekolah'),
                                    ])
                            ])
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('Sales ID')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('user.detail.full_name')
                    ->label('Nama Pembeli')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('paymentMethod.name')
                    ->label('Metode Pembayaran')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('type')
                    ->label('Tipe')
                    ->color(Color::Blue)
                    ->badge()
                    ->sortable()
                    ->searchable(),
                TextColumn::make('status.name')
                    ->label('Status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        SalesEntities::SALES_STATUS_NOT_PAID_TEXT => 'gray',
                        SalesEntities::SALES_STATUS_PROCESSING_TEXT => 'warning',
                        SalesEntities::SALES_STATUS_PAID_TEXT => 'success',
                        SalesEntities::SALES_STATUS_EXPIRED_TEXT => 'danger',
                        SalesEntities::SALES_STATUS_CANCELLED_TEXT => 'danger',
                        SalesEntities::SALES_STATUS_FAILED_TEXT => 'danger',
                        default => 'gray',
                    })
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
//                Tables\Actions\EditAction::make()->label('Detail'),
                Tables\Actions\ViewAction::make(),
            ])
//            ->bulkActions([
//                Tables\Actions\BulkActionGroup::make([
//                    Tables\Actions\DeleteBulkAction::make(),
//                ]),
//            ])
            ->emptyStateActions([
//                Tables\Actions\CreateAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\DetailsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSales::route('/'),
//            'create' => Pages\CreateSales::route('/create'),
//            'edit' => Pages\EditSales::route('/{record}/edit'),
            'view' => Pages\ViewSales::route('/{record}'),
        ];
    }
}

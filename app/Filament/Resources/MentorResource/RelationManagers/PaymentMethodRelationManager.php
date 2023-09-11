<?php

namespace App\Filament\Resources\MentorResource\RelationManagers;

use App\Entities\MentorEntities;
use App\Models\Payments\PaymentMethod;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class PaymentMethodRelationManager extends RelationManager
{
    protected static string $relationship = 'paymentMethod';
    protected static ?string $title = 'Metode Pembayaran';

    public static function canViewForRecord(Model $ownerRecord, string $pageClass): bool
    {
        return (int)$ownerRecord->status->value === MentorEntities::MENTOR_STATUS_APPROVED;
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('payment_method_id')
                    ->label('Metode Pembayaran')
                    ->options(PaymentMethod::active()->get()->pluck('name', 'id'))
                    ->required(),
                Forms\Components\TextInput::make('bank_name')
                    ->required()
                    ->label('Nama Bank')
                    ->placeholder('Contoh: BCA')
                    ->hint('Nama bank pada buku tabungan')
                    ->maxLength(255),
                Forms\Components\TextInput::make('account_name')
                    ->required()
                    ->label('Nama Pemilik Rekening')
                    ->placeholder('Contoh: John Doe')
                    ->maxLength(30),
                Forms\Components\TextInput::make('account_number')
                    ->required()
                    ->label('Nomor Rekening')
                    ->placeholder('Contoh: 1234567890')
                    ->maxLength(30),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('bank_name')
            ->columns([
                Tables\Columns\TextColumn::make('bank_name')
                    ->label('Nama Bank')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('account_name')
                    ->label('Nama Pemilik Rekening')
                    ->copyable()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('account_number')
                    ->label('Nomor Rekening')
                    ->copyable()
                    ->searchable()
                    ->sortable()
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
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
                Tables\Actions\CreateAction::make(),
            ]);
    }
}

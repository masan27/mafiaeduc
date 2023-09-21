<?php

namespace App\Filament\Resources\SalesResource\Pages;

use App\Entities\SalesEntities;
use App\Filament\Resources\SalesResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\ViewRecord;
use Filament\Support\Colors\Color;

class ViewSales extends ViewRecord
{
    protected static string $resource = SalesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('accept')
                ->label('Terima')
                ->hidden(fn() => $this->record->sales_status_id !== SalesEntities::SALES_STATUS_PROCESSING
                    && $this->record->sales_status_id !== SalesEntities::SALES_STATUS_EXPIRED)
                ->requiresConfirmation(),
            Action::make('decline')
                ->label('Tolak')
                ->requiresConfirmation()
                ->color(Color::Red)
                ->hidden(fn() => $this->record->sales_status_id !== SalesEntities::SALES_STATUS_PROCESSING
                    && $this->record->sales_status_id !== SalesEntities::SALES_STATUS_EXPIRED)
                ->action(function ($record): void {
                    $record->sales_status_id = SalesEntities::SALES_STATUS_FAILED;
                    $record->save();
                })
        ];
    }
}

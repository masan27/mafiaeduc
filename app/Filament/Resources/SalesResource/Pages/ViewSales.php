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
                ->disabled(function ($record) {
                    if ((int)$record->type->value === SalesEntities::PRIVATE_CLASSES_TYPE) {
                        $exist = $record->details[0]->privateClassSchedule;
                        if ($exist) {
                            return false;
                        } else {
                            return true;
                        }
                    } else if ((int)$record->type->value === SalesEntities::GROUP_CLASSES_TYPE) {
                        $exist = $record->details[0]->groupClassSchedule;
                        if ($exist) {
                            return false;
                        } else {
                            return true;
                        }
                    } else {
                        return false;
                    }
                })
                ->hidden(fn() => $this->record->sales_status_id !== SalesEntities::SALES_STATUS_PROCESSING
                    && $this->record->sales_status_id !== SalesEntities::SALES_STATUS_EXPIRED)
                ->requiresConfirmation()
                ->action(function ($record): void {
                    $userId = $record->user->id;

                    if ((int)$record->type->value === SalesEntities::PRIVATE_CLASSES_TYPE) {
                        foreach ($record->details as $detail) {
                            $schedule = $detail->privateClassSchedule;
                            $schedule->users()->attach($userId);
                        }
                    } else if ((int)$record->type->value === SalesEntities::GROUP_CLASSES_TYPE) {
                        foreach ($record->details as $detail) {
                            $schedule = $detail->groupClassSchedule;
                            $schedule->users()->attach($userId);
                        }
                    } else {
                        foreach ($record->details as $detail) {
                            $schedule = $detail->material;
                            $schedule->users()->attach($userId);
                        }
                    }

                    $record->sales_status_id = SalesEntities::SALES_STATUS_PAID;
                    $record->save();
                }),
            Action::make('decline')
                ->label('Tolak')
                ->requiresConfirmation()
                ->color(Color::Red)
                ->disabled(function ($record) {
                    if ((int)$record->type->value === SalesEntities::PRIVATE_CLASSES_TYPE) {
                        $exist = $record->details[0]->privateClassSchedule;
                        if ($exist) {
                            return false;
                        } else {
                            return true;
                        }
                    } else if ((int)$record->type->value === SalesEntities::GROUP_CLASSES_TYPE) {
                        $exist = $record->details[0]->groupClassSchedule;
                        if ($exist) {
                            return false;
                        } else {
                            return true;
                        }
                    } else {
                        return false;
                    }
                })
                ->hidden(fn() => $this->record->sales_status_id !== SalesEntities::SALES_STATUS_PROCESSING
                    && $this->record->sales_status_id !== SalesEntities::SALES_STATUS_EXPIRED)
                ->action(function ($record): void {
                    $record->sales_status_id = SalesEntities::SALES_STATUS_FAILED;
                    $record->save();
                })
        ];
    }
}

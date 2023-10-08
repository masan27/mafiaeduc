<?php

namespace App\Filament\Resources\SalesResource\Pages;

use App\Entities\NotificationEntities;
use App\Entities\SalesEntities;
use App\Filament\Resources\SalesResource;
use App\Repository\Notifications\NotificationRepo;
use Filament\Actions\Action;
use Filament\Resources\Pages\ViewRecord;
use Filament\Support\Colors\Color;
use Illuminate\Support\Carbon;

class ViewSales extends ViewRecord
{
    protected static string $resource = SalesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('accept')
                ->label('Terima')
                ->disabled(function ($record) {
                    $result = false;
                    if ((int)$record->type->value === SalesEntities::PRIVATE_CLASSES_TYPE) {
                        $exist = $record->detail->products;
                        foreach ($exist as $item) {
                            if ($item->getTable() == 'private_classes') {
                                $exist = true;
                                break;
                            }
                        }
                        return $result;
                    } else if ((int)$record->type->value === SalesEntities::GROUP_CLASSES_TYPE) {
                        $exist = $record->detail->products;
                        foreach ($exist as $item) {
                            if ($item->getTable() == 'group_classes') {
                                $exist = true;
                                break;
                            }
                        }
                        return $exist;
                    } else {
                        return false;
                    }
                })
                ->hidden(fn () => $this->record->sales_status_id !== SalesEntities::SALES_STATUS_PROCESSING
                    && $this->record->sales_status_id !== SalesEntities::SALES_STATUS_EXPIRED)
                ->requiresConfirmation()
                ->action(function ($record): void {
                    $userId = $record->user->id;

                    if ((int)$record->type->value === SalesEntities::PRIVATE_CLASSES_TYPE) {
                        foreach ($record->detail->products as $item) {
                            if ($item->getTable() == 'private_classes') {
                                $schedule = $record->detail->privateClassSchedule;
                                $schedule->users()->attach($userId);
                                break;
                            }
                        }
                    } else if ((int)$record->type->value === SalesEntities::GROUP_CLASSES_TYPE) {
                        foreach ($record->detail->products as $item) {
                            if ($item->getTable() == 'group_classes') {
                                $schedule = $record->detail->groupClassSchedule;
                                $schedule->users()->attach($userId);
                                break;
                            }
                        }
                    } else {
                        foreach ($record->detail->products as $item) {
                            if ($item->getTable() == 'materials') {
                                $schedule = $record->detail->material;
                                $schedule->users()->attach($userId);
                                break;
                            }
                        }
                    }

                    $salesId = $record->id;

                    NotificationRepo::updateUserNotification(
                        $salesId,
                        'Pembayaran Berhasil',
                        'Pembayaran Anda berhasil, silahkan cek status pembayaran Anda di halaman transaksi',
                        NotificationEntities::TYPE_PAYMENT
                    );

                    $record->sales_status_id = SalesEntities::SALES_STATUS_PAID;
                    $record->payment_date = Carbon::now();
                    $record->save();
                }),
            Action::make('decline')
                ->label('Tolak')
                ->requiresConfirmation()
                ->color(Color::Red)
                ->disabled(function ($record) {
                    $result = true;
                    if ((int)$record->type->value === SalesEntities::PRIVATE_CLASSES_TYPE) {
                        $exist = $record->detail->products;
                        foreach ($exist as $item) {
                            if ($item->getTable() == 'private_classes') {
                                $exist = false;
                                break;
                            }
                        }
                        return $result;
                    } else if ((int)$record->type->value === SalesEntities::GROUP_CLASSES_TYPE) {
                        $exist = $record->detail->products;
                        foreach ($exist as $item) {
                            if ($item->getTable() == 'group_classes') {
                                $exist = false;
                                break;
                            }
                        }
                        return $result;
                    } else {
                        return false;
                    }
                })
                ->hidden(fn () => $this->record->sales_status_id !== SalesEntities::SALES_STATUS_PROCESSING
                    && $this->record->sales_status_id !== SalesEntities::SALES_STATUS_EXPIRED)
                ->action(function ($record): void {
                    $salesId = $record->id;

                    NotificationRepo::updateUserNotification(
                        $salesId,
                        'Pembayaran Gagal',
                        'Pembayaran Anda gagal, silahkan tunggu pengembalian dana Anda dalam 1x24 jam',
                        NotificationEntities::TYPE_PAYMENT
                    );

                    $record->sales_status_id = SalesEntities::SALES_STATUS_FAILED;
                    $record->save();
                })
        ];
    }
}

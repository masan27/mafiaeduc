<?php

namespace App\Filament\Resources\AppContactResource\Pages;

use App\Filament\Resources\AppContactResource;
use App\Models\Contacts\AppContact;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageAppContacts extends ManageRecords
{
    protected static string $resource = AppContactResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->hidden(function () {
                return AppContact::count() >= 1;
            }),
        ];
    }
}

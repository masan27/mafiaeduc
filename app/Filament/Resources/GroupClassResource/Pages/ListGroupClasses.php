<?php

namespace App\Filament\Resources\GroupClassResource\Pages;

use App\Filament\Resources\GroupClassResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListGroupClasses extends ListRecords
{
    protected static string $resource = GroupClassResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

<?php

namespace App\Filament\Resources\PrivateClassResource\Pages;

use App\Filament\Resources\PrivateClassResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPrivateClass extends EditRecord
{
    protected static string $resource = PrivateClassResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

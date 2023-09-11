<?php

namespace App\Filament\Resources\LearningMethodResource\Pages;

use App\Filament\Resources\LearningMethodResource;
use Filament\Resources\Pages\ManageRecords;

class ManageLearningMethods extends ManageRecords
{
    protected static string $resource = LearningMethodResource::class;

    protected function getHeaderActions(): array
    {
        return [
//            Actions\CreateAction::make(),
        ];
    }
}

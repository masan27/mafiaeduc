<?php

namespace App\enums;

use Filament\Support\Contracts\HasLabel;

enum SalesTypeEnum: string implements HasLabel
{
    case PRIVATE_CLASSES_TYPE = '1';
    case GROUP_CLASSES_TYPE = '2';
    case MATERIALS_TYPE = '3';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::PRIVATE_CLASSES_TYPE => 'Kelas Privat',
            self::GROUP_CLASSES_TYPE => 'Kelas Grup',
            self::MATERIALS_TYPE => 'Bahan Ajar',
        };
    }
}

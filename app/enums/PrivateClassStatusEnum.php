<?php

namespace App\enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum PrivateClassStatusEnum: string implements HasLabel, HasColor
{
    case STATUS_DAFTED = '0';
    case STATUS_PUBLISHED = '1';
    case STATUS_PURCHASED = '2';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::STATUS_DAFTED => 'Dafted',
            self::STATUS_PUBLISHED => 'Published',
            self::STATUS_PURCHASED => 'Purchased',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::STATUS_DAFTED => 'warning',
            self::STATUS_PUBLISHED => 'success',
            self::STATUS_PURCHASED => 'danger',
        };
    }
}

<?php

namespace App\enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum StatusEnum: string implements HasLabel, HasColor, HasIcon
{
    case Active = '1';
    case NonActive = '0';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Active => 'Aktif',
            self::NonActive => 'Tidak Aktif',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Active => 'success',
            self::NonActive => 'danger',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::Active => 'heroicon-o-check-circle',
            self::NonActive => 'heroicon-o-x-circle',
        };
    }
}

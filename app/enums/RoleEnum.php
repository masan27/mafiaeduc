<?php

namespace App\enums;

use Filament\Support\Contracts\HasLabel;

enum RoleEnum: string implements HasLabel
{
    case ROLE_ADMIN = '1';
    case ROLE_MENTOR = '2';
    case ROLE_USER = '3';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::ROLE_ADMIN => 'Admin',
            self::ROLE_MENTOR => 'Mentor',
            self::ROLE_USER => 'User',
        };
    }
}

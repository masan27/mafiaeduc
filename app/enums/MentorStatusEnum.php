<?php

namespace App\enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum MentorStatusEnum: string implements HasLabel, HasColor
{
    case MENTOR_STATUS_PENDING_APPROVAL = '0';
    case MENTOR_STATUS_APPROVED = '1';
    case MENTOR_STATUS_REJECTED = '2';
    case MENTOR_STATUS_BLOCKED = '3';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::MENTOR_STATUS_PENDING_APPROVAL => 'Menunggu Persetujuan',
            self::MENTOR_STATUS_APPROVED => 'Diterima',
            self::MENTOR_STATUS_REJECTED => 'Ditolak',
            self::MENTOR_STATUS_BLOCKED => 'Diblokir',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::MENTOR_STATUS_PENDING_APPROVAL => 'warning',
            self::MENTOR_STATUS_APPROVED => 'success',
            self::MENTOR_STATUS_REJECTED, self::MENTOR_STATUS_BLOCKED => 'danger',
        };
    }
}

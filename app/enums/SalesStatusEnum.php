<?php

namespace App\enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum SalesStatusEnum: string implements HasLabel, HasColor
{
    case SALES_STATUS_NOT_PAID = '1';
    case SALES_STATUS_PROCESSING = '2';
    case SALES_STATUS_PAID = '3';
    case SALES_STATUS_EXPIRED = '4';
    case SALES_STATUS_CANCELLED = '5';
    case SALES_STATUS_FAILED = '6';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::SALES_STATUS_NOT_PAID => 'Belum Bayar',
            self::SALES_STATUS_PROCESSING => 'Sedang Diproses',
            self::SALES_STATUS_PAID => 'Sudah Bayar',
            self::SALES_STATUS_EXPIRED => 'Kadaluarsa',
            self::SALES_STATUS_CANCELLED => 'Dibatalkan',
            self::SALES_STATUS_FAILED => 'Gagal',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::SALES_STATUS_NOT_PAID => 'gray',
            self::SALES_STATUS_PROCESSING => 'yellow',
            self::SALES_STATUS_PAID => 'green',
            self::SALES_STATUS_EXPIRED, self::SALES_STATUS_CANCELLED, self::SALES_STATUS_FAILED => 'red',
        };
    }
}

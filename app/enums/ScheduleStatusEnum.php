<?php

namespace App\enums;

use Filament\Support\Contracts\HasLabel;

enum ScheduleStatusEnum: string implements HasLabel
{
    case CLASS_IS_DONE = '1';

    case CLASS_IS_NOT_DONE = '0';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::CLASS_IS_DONE => 'Selesai',
            self::CLASS_IS_NOT_DONE => 'Belum Selesai',
        };
    }

}

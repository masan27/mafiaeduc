<?php

namespace App\Entities;

class PrivateClassEntities
{
    const STATUS_DAFTED = 0;
    const STATUS_PUBLISHED = 1;
    const STATUS_PURCHASED = 2;

    const STATUS = [
        self::STATUS_DAFTED => 'Dafted',
        self::STATUS_PUBLISHED => 'Published',
        self::STATUS_PURCHASED => 'Purchased',
    ];
}

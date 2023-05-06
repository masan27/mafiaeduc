<?php

namespace App\Entities;

class NotificationEntities
{

    const STATUS_READ = 1;
    const STATUS_UNREAD = 0;

    const TYPE_GENERAL = 'general';
    const TYPE_ORDER = 'order';
    const TYPE_PAYMENT = 'payment';
    const TYPE_OTHER = 'other';

    const STATUS_DRAFTED = 'drafted';
    const STATUS_DELIVERED = 'delivered';
    const STATUS_DELETED = 'deleted';

    const TYPES = [
        self::TYPE_GENERAL,
        self::TYPE_ORDER,
        self::TYPE_PAYMENT,
        self::TYPE_OTHER,
    ];
}

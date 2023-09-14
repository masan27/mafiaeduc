<?php

namespace App\Entities;

class SalesEntities
{
    const SALES_STATUS_NOT_PAID = 1;
    const SALES_STATUS_PROCESSING = 2;
    const SALES_STATUS_PAID = 3;
    const SALES_STATUS_EXPIRED = 4;
    const SALES_STATUS_CANCELLED = 5;
    const SALES_STATUS_FAILED = 6;

    const SALES_STATUS_NOT_PAID_TEXT = 'Belum Bayar';
    const SALES_STATUS_PROCESSING_TEXT = 'Sedang Diproses';
    const SALES_STATUS_PAID_TEXT = 'Sudah Bayar';
    const SALES_STATUS_EXPIRED_TEXT = 'Kadaluarsa';
    const SALES_STATUS_CANCELLED_TEXT = 'Dibatalkan';
    const SALES_STATUS_FAILED_TEXT = 'Gagal';

    const PRIVATE_CLASSES_TYPE = 1;
    const GROUP_CLASSES_TYPE = 2;
    const MATERIALS_TYPE = 3;

    const PRIVATE_CLASSES_TYPE_PREFIX = 'PC';
    const GROUP_CLASSES_TYPE_PREFIX = 'GC';
    const MATERIALS_TYPE_PREFIX = 'MA';
}

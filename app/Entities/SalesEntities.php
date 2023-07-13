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

    const PRIVATE_CLASSES_TYPE = 1;
    const GROUP_CLASSES_TYPE = 2;
    const MATERIALS_TYPE = 3;
}

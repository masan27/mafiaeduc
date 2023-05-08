<?php

namespace App\Entities;

class PaymentMethodEntities
{
    const PAYMENT_METHOD_STATUS_ACTIVE = 1;
    const PAYMENT_METHOD_STATUS_INACTIVE = 0;

    const PAYMENT_METHOD_TYPE_BANK = 'bank';

    const PAYMENT_METHOD_CODE_BCA = 'bca';

    const PAYMENT_METHOD_CODE_BNI = 'bni';

    const PAYMENT_METHOD_CODE_BRI = 'bri';

    const PAYMENT_METHOD_CODE_MANDIRI = 'mandiri';
}

<?php

namespace App\Repository\Payments;

use App\Entities\PaymentMethodEntities;
use App\Traits\RepoTrait;
use Illuminate\Support\Facades\DB;

class PaymentMethodRepo implements PaymentMethodRepoInterface
{
    use RepoTrait;

    public static function getActivePaymentMethods()
    {
        return self::getDbTable()
            ->where('status', PaymentMethodEntities::PAYMENT_METHOD_STATUS_ACTIVE)
            ->select('id', 'name', 'description', 'icon', 'fee', 'account_number', 'type')
            ->get();
    }

    private static function getDbTable()
    {
        return DB::table('payment_methods');
    }
}

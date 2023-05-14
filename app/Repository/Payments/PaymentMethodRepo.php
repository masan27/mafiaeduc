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

    private static function getDbTable(): object
    {
        return DB::table('payment_methods');
    }

    public static function insertPaymentMethod($name, $fee, $code, $account_number, $icon, $type, $description)
    {
        return self::getDbTable()
            ->insert([
                'name' => $name,
                'fee' => $fee,
                'code' => $code,
                'account_number' => $account_number,
                'icon' => $icon,
                'type' => $type,
                'description' => $description,
                'status' => PaymentMethodEntities::PAYMENT_METHOD_STATUS_ACTIVE,
                'created_at' => now(),
                'updated_at' => now()
            ]);
    }

    public static function getPaymentMethod($paymentMethodId)
    {
        return self::getDbTable()
            ->where('id', $paymentMethodId)
            ->select('id', 'name', 'description', 'icon', 'fee', 'account_number', 'type', 'code', 'status')
            ->first();
    }

    public static function updatePaymentMethodStatus($paymentMethodId, $status)
    {
        return self::getDbTable()
            ->where('id', $paymentMethodId)
            ->update([
                'status' => $status,
                'updated_at' => now()
            ]);
    }
}

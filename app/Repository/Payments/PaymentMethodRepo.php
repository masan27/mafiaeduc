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
            ->select('id', 'name', 'description', 'fee', 'account_number', 'type', 'status')
            ->get();
    }

    public static function getAllPaymentMethods(string|null $search)
    {
        $query = self::getDbTable()
            ->select('id', 'name', 'description', 'fee', 'account_number', 'type', 'status');

        if ($search) {
            $query->where('name', 'like', "%$search")
                ->orWhere('account_number', 'like', "%$search")
                ->orWhere('fee', 'like', "%$search")
                ->orWhere('code', 'like', "%$search");
        }

        return $query->get();
    }

    private static function getDbTable(): object
    {
        return DB::table('payment_methods');
    }

    public static function insertPaymentMethod($name, $fee, $code, $account_number, $type, $description)
    {
        return self::getDbTable()
            ->insert([
                'name' => $name,
                'fee' => $fee,
                'code' => $code,
                'account_number' => $account_number,
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
            ->select('id', 'name', 'description', 'fee', 'account_number', 'type', 'code', 'status')
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

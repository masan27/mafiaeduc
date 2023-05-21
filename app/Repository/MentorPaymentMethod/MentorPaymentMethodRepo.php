<?php

namespace App\Repository\MentorPaymentMethod;

use App\Traits\RepoTrait;
use Illuminate\Support\Facades\DB;

class MentorPaymentMethodRepo implements MentorPaymentMethodRepoInterface
{
    use RepoTrait;

    private static function getDbTable(): object
    {
        return DB::table('mentor_payment_methods');
    }

    public static function getAllMentorPaymentMethod($mentorId): object
    {
        return self::getDbTable()
            ->leftJoin('payment_methods', 'mentor_payment_methods.payment_method_id', '=', 'payment_methods.id')
            ->where('mentor_id', $mentorId)
            ->select(
                'mentor_payment_methods.id',
                'mentor_payment_methods.mentor_id',
                'mentor_payment_methods.payment_method_id',
                'payment_methods.name',
                'payment_methods.icon',
                'payment_methods.code',
                'payment_methods.type',
                'mentor_payment_methods.account_number',
                'mentor_payment_methods.account_name',
                'mentor_payment_methods.bank_name',
            )->get();
    }

    public static function addMentorPaymentMethod($mentorId, $paymentMethodId, $accountNumber,
                                                  $accountName, $bankName): bool
    {
        return self::getDbTable()->insert([
            'mentor_id' => $mentorId,
            'payment_method_id' => $paymentMethodId,
            'account_number' => $accountNumber,
            'account_name' => $accountName,
            'bank_name' => $bankName,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public static function deleteMentorPaymentMethod($mentorId, $mentorPaymentMethodId): bool
    {
        return self::getDbTable()
            ->where('mentor_id', $mentorId)
            ->where('id', $mentorPaymentMethodId)
            ->delete();
    }
}

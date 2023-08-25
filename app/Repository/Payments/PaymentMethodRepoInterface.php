<?php

namespace App\Repository\Payments;

interface PaymentMethodRepoInterface
{
    public static function getActivePaymentMethods();

    public static function getAllPaymentMethods(string|null $search);

    public static function getPaymentMethod(int $paymentMethodId);

    public static function updatePaymentMethodStatus(int $paymentMethodId, int $status);

    public static function insertPaymentMethod(
        string $name,
        int    $fee,
        string $code, string $account_number, string $type,
        string $description
    );
}

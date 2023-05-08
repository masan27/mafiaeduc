<?php

namespace App\Repository\Payments;

interface PaymentMethodRepoInterface
{
    public static function getActivePaymentMethods();
}

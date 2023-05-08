<?php

namespace App\Services\Payments;

interface PaymentMethodServiceInterface
{
    public function getPaymentMethods(): array;
}

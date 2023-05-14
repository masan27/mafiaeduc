<?php

namespace App\Services\Payments;

use Illuminate\Http\Request;

interface PaymentMethodServiceInterface
{
    public function getPaymentMethods(): array;

    public function addPaymentMethod(Request $request): array;

    public function nonActivePaymentMethod(Request $request): array;
}

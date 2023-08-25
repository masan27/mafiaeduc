<?php

namespace App\Services\Payments;

use Illuminate\Http\Request;

interface PaymentMethodServiceInterface
{
    public function getPaymentMethods(): array;

    public function getAdminPaymentMethods(Request $request): array;

    public function addPaymentMethod(Request $request): array;

    public function editPaymentMethod(string $paymentMethodId, Request $request): array;

    public function deletePaymentMethod(string $paymentMethodId): array;

    public function nonActivePaymentMethod(Request $request): array;
}

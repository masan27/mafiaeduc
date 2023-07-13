<?php

namespace App\Services\Checkouts;

use Illuminate\Http\Request;

interface CheckoutServiceInterface
{
    public function makeCheckout(Request $request): array;

    public function getInvoiceDetails($salesId, Request $request): array;

    public function paymentConfirmation(Request $request): array;

    public function cancelPayment(Request $request): array;
}

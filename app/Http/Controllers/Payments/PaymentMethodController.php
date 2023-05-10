<?php

namespace App\Http\Controllers\Payments;

use App\Http\Controllers\Controller;
use App\Services\Payments\PaymentMethodServiceInterface;
use Illuminate\Http\JsonResponse;

class PaymentMethodController extends Controller
{
    protected PaymentMethodServiceInterface $paymentMethodService;

    public function __construct(PaymentMethodServiceInterface $paymentMethodService)
    {
        $this->paymentMethodService = $paymentMethodService;
    }

    public function getPaymentMethods(): JsonResponse
    {
        $data = $this->paymentMethodService->getPaymentMethods();
        return response()->json($data, $data['code']);
    }
}

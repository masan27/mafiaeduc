<?php

namespace App\Http\Controllers\Payments;

use App\Http\Controllers\Controller;
use App\Services\Payments\PaymentMethodServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AdminPaymentMethodController extends Controller
{
    protected PaymentMethodServiceInterface $paymentMethodService;

    public function __construct(PaymentMethodServiceInterface $paymentMethodService)
    {
        $this->paymentMethodService = $paymentMethodService;
    }

    public function getAdminPaymentMethods(Request $request): JsonResponse
    {
        $data = $this->paymentMethodService->getAdminPaymentMethods($request);
        return response()->json($data, $data['code']);
    }

    public function addPaymentMethod(Request $request): JsonResponse
    {
        $data = $this->paymentMethodService->addPaymentMethod($request);
        return response()->json($data, $data['code']);
    }

    public function editPaymentMethod(string $paymentMethodId, Request $request): JsonResponse
    {
        $data = $this->paymentMethodService->editPaymentMethod($paymentMethodId, $request);
        return response()->json($data, $data['code']);
    }

    public function nonActivePaymentMethod(Request $request): JsonResponse
    {
        $data = $this->paymentMethodService->nonActivePaymentMethod($request);
        return response()->json($data, $data['code']);
    }

    public function deletePaymentMethod(string $paymentMethodId): JsonResponse
    {
        $data = $this->paymentMethodService->deletePaymentMethod($paymentMethodId);
        return response()->json($data, $data['code']);
    }
}

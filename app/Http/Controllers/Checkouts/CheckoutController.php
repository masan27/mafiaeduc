<?php

namespace App\Http\Controllers\Checkouts;

use App\Http\Controllers\Controller;
use App\Services\Checkouts\CheckoutServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    protected CheckoutServiceInterface $checkoutService;

    public function __construct(CheckoutServiceInterface $checkoutService)
    {
        $this->checkoutService = $checkoutService;
    }

    public function makeCheckout(Request $request): JsonResponse
    {
        $data = $this->checkoutService->makeCheckout($request);
        return response()->json($data, $data['code']);
    }

    public function getInvoiceDetails(string $salesId, Request $request): JsonResponse
    {
        $data = $this->checkoutService->getInvoiceDetails($salesId, $request);
        return response()->json($data, $data['code']);
    }

    public function paymentConfirmation(Request $request): JsonResponse
    {
        $data = $this->checkoutService->paymentConfirmation($request);
        return response()->json($data, $data['code']);
    }

    public function cancelPayment(Request $request): JsonResponse
    {
        $data = $this->checkoutService->cancelPayment($request);
        return response()->json($data, $data['code']);
    }
}

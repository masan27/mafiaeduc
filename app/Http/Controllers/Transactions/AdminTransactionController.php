<?php

namespace App\Http\Controllers\Transactions;

use App\Http\Controllers\Controller;
use App\Services\Admins\Transactions\AdminTransactionServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AdminTransactionController extends Controller
{
    protected AdminTransactionServiceInterface $adminTransactionService;

    public function __construct(AdminTransactionServiceInterface $adminTransactionService)
    {
        $this->adminTransactionService = $adminTransactionService;
    }

    public function getAllTransactions(Request $request): JsonResponse
    {
        $data = $this->adminTransactionService->getAllTransactions($request);
        return response()->json($data, $data['code']);
    }

    public function getTransactionDetails(string $salesId): JsonResponse
    {
        $data = $this->adminTransactionService->getTransactionDetails($salesId);
        return response()->json($data, $data['code']);
    }

    public function confirmTransaction(Request $request): JsonResponse
    {
        $data = $this->adminTransactionService->confirmTransaction($request);
        return response()->json($data, $data['code']);
    }

    public function declineTransaction(Request $request): JsonResponse
    {
        $data = $this->adminTransactionService->declineTransaction($request);
        return response()->json($data, $data['code']);
    }
}

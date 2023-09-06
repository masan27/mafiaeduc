<?php

namespace App\Services\Admins\Transactions;

use Illuminate\Http\Request;

interface AdminTransactionServiceInterface
{
    public function getAllTransactions(Request $request): array;

    public function getTransactionDetails(string $salesId): array;

    public function confirmTransaction(Request $request): array;

    public function declineTransaction(Request $request): array;
}

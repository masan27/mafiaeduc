<?php

namespace App\Services\Reviews;

use Illuminate\Http\Request;

interface ReviewServiceInterface
{
    public function addTransactionReview(Request $request): array;
}

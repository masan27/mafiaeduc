<?php

namespace App\Http\Controllers\Reviews;

use App\Http\Controllers\Controller;
use App\Services\Reviews\ReviewServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    protected ReviewServiceInterface $reviewService;

    public function __construct(ReviewServiceInterface $reviewService)
    {
        $this->reviewService = $reviewService;
    }

    public function addTransactionReview(Request $request): JsonResponse
    {
        $data = $this->reviewService->addTransactionReview($request);
        return response()->json($data, $data['code']);
    }
}

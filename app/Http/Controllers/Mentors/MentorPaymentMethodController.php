<?php

namespace App\Http\Controllers\Mentors;

use App\Http\Controllers\Controller;
use App\Services\Mentors\PaymentMethod\MentorPaymentMethodServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MentorPaymentMethodController extends Controller
{
    protected MentorPaymentMethodServiceInterface $mentorPaymentMethodService;

    public function __construct(MentorPaymentMethodServiceInterface $mentorPaymentMethodService)
    {
        $this->mentorPaymentMethodService = $mentorPaymentMethodService;
    }

    public function getMentorPaymentMethods(Request $request): JsonResponse
    {
        $data = $this->mentorPaymentMethodService->getMentorPaymentMethod($request);
        return response()->json($data, $data['code']);
    }

    public function addMentorPaymentMethod(Request $request): JsonResponse
    {
        $data = $this->mentorPaymentMethodService->addMentorPaymentMethod($request);
        return response()->json($data, $data['code']);
    }

    public function deleteMentorPaymentMethod(Request $request): JsonResponse
    {
        $data = $this->mentorPaymentMethodService->deleteMentorPaymentMethod($request);
        return response()->json($data, $data['code']);
    }
}

<?php

namespace App\Services\Mentors\PaymentMethod;

use Illuminate\Http\Request;

interface MentorPaymentMethodServiceInterface
{
    public function getMentorPaymentMethod(Request $request): array;

    public function addMentorPaymentMethod(Request $request): array;

    public function deleteMentorPaymentMethod(Request $request): array;
}

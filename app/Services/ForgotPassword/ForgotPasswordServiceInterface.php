<?php

namespace App\Services\ForgotPassword;

use Illuminate\Http\Request;

interface ForgotPasswordServiceInterface
{
    public function sendResetLinkEmail(Request $request): array;

    public function resetPassword(Request $request): array;

    public function verifyOtp(Request $request): array;
}

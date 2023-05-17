<?php

namespace App\Services\Mentors\Auth;

use Illuminate\Http\Request;

interface MentorAuthServiceInterface
{
    public function login(Request $request): array;

    public function logout(Request $request): array;

    public function resetPassword(Request $request): array;

    public function sendResetLinkEmail(Request $request): array;
}

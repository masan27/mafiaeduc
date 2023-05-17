<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\Mentors\Auth\MentorAuthServiceInterface;
use App\Services\Mentors\MentorServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MentorAuthController extends Controller
{
    protected MentorAuthServiceInterface $mentorAuthService;
    protected MentorServiceInterface $mentorService;

    public function __construct(
        MentorAuthServiceInterface $mentorAuthService,
        MentorServiceInterface     $mentorService
    )
    {
        $this->mentorAuthService = $mentorAuthService;
        $this->mentorService = $mentorService;
    }

    public function login(Request $request): JsonResponse
    {
        $data = $this->mentorAuthService->login($request);
        return response()->json($data, $data['code']);
    }

    public function getProfileDetails(Request $request): JsonResponse
    {
        $data = $this->mentorService->getProfileDetails($request);
        return response()->json($data, $data['code']);
    }

    public function logout(Request $request): JsonResponse
    {
        $data = $this->mentorAuthService->logout($request);
        return response()->json($data, $data['code']);
    }

    public function resetPassword(Request $request): JsonResponse
    {
        $data = $this->mentorAuthService->resetPassword($request);
        return response()->json($data, $data['code']);
    }

    public function sendResetLinkEmail(Request $request): JsonResponse
    {
        $data = $this->mentorAuthService->sendResetLinkEmail($request);
        return response()->json($data, $data['code']);
    }
}

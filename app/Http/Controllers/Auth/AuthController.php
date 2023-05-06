<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\Auth\AuthServiceInterface;
use App\Services\ForgotPassword\ForgotPasswordServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    private AuthServiceInterface $authService;
    private ForgotPasswordServiceInterface $forgotPasswordService;

    public function __construct(AuthServiceInterface $authService, ForgotPasswordServiceInterface $forgotPasswordService)
    {
        $this->authService = $authService;
        $this->forgotPasswordService = $forgotPasswordService;
    }

    public function login(Request $request): JsonResponse
    {
        $data = $this->authService->login($request);
        return response()->json($data, $data['code']);
    }

    public function register(Request $request): JsonResponse
    {
        $data = $this->authService->register($request);
        return response()->json($data, $data['code']);
    }

    public function logout(Request $request): JsonResponse
    {
        $data = $this->authService->logout($request);
        return response()->json($data, $data['code']);
    }

    public function getUser(Request $request): JsonResponse
    {
        $data = $this->authService->getUser($request);
        return response()->json($data, $data['code']);
    }

    public function sendResetLinkEmail(Request $request): JsonResponse
    {
        $data = $this->forgotPasswordService->sendResetLinkEmail($request);
        return response()->json($data, $data['code']);
    }

    public function resetPassword(Request $request): JsonResponse
    {
        $data = $this->forgotPasswordService->resetPassword($request);
        return response()->json($data, $data['code']);
    }

    public function verifyOtp(Request $request): JsonResponse
    {
        $data = $this->forgotPasswordService->verifyOtp($request);
        return response()->json($data, $data['code']);
    }
}

<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\Auth\AuthServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    private AuthServiceInterface $authService;

    public function __construct(AuthServiceInterface $authService)
    {
        $this->authService = $authService;
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
}

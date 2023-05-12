<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\Admins\Auth\AdminAuthServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AdminAuthController extends Controller
{
    protected AdminAuthServiceInterface $adminAuthService;

    public function __construct(AdminAuthServiceInterface $adminAuthService)
    {
        $this->adminAuthService = $adminAuthService;
    }

    public function login(Request $request): JsonResponse
    {
        $data = $this->adminAuthService->getLoginToken($request);
        return response()->json($data, $data['code']);
    }

    public function register(Request $request): JsonResponse
    {
        $data = $this->adminAuthService->addNewAdmin($request);
        return response()->json($data, $data['code']);
    }

    public function logout(Request $request): JsonResponse
    {
        $data = $this->adminAuthService->logout($request);
        return response()->json($data, $data['code']);
    }

    public function getProfileDetails(Request $request): JsonResponse
    {
        $data = $this->adminAuthService->getAdminProfileDetails($request);
        return response()->json($data, $data['code']);
    }
}

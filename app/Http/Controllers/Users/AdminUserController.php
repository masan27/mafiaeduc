<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Services\Admins\Users\AdminUserServiceInterface;
use Illuminate\Http\JsonResponse;

class AdminUserController extends Controller
{
    protected AdminUserServiceInterface $adminUserService;

    public function __construct(AdminUserServiceInterface $adminUserService)
    {
        $this->adminUserService = $adminUserService;
    }

    public function getAllUsers(): JsonResponse
    {
        $data = $this->adminUserService->getAllUsers();
        return response()->json($data, $data['code']);
    }

    public function getUserDetails(int $userId): JsonResponse
    {
        $data = $this->adminUserService->getUserDetails($userId);
        return response()->json($data, $data['code']);
    }

    public function resetPassword(int $userId): JsonResponse
    {
        $data = $this->adminUserService->resetPassword($userId);
        return response()->json($data, $data['code']);
    }

    public function nonActiveUsers(int $userId): JsonResponse
    {
        $data = $this->adminUserService->nonActiveUsers($userId);
        return response()->json($data, $data['code']);
    }
}

<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Services\Users\UserServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private UserServiceInterface $userService;

    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    public function getUserDetails(Request $request): JsonResponse
    {
        $data = $this->userService->getUserDetails($request);
        return response()->json($data, $data['code']);
    }

    public function updateUserDetails(Request $request): JsonResponse
    {
        $data = $this->userService->updateUserDetails($request);
        return response()->json($data, $data['code']);
    }

    public function changePassword(Request $request): JsonResponse
    {
        $data = $this->userService->changePassword($request);
        return response()->json($data, $data['code']);
    }
}

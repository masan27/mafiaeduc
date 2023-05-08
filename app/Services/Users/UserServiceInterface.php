<?php

namespace App\Services\Users;

use Illuminate\Http\Request;

interface UserServiceInterface
{
    public function getUserDetails(Request $request): array;

    public function updateUserDetails(Request $request): array;

    public function changePassword(Request $request): array;
}

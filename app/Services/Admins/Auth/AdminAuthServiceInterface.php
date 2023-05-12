<?php

namespace App\Services\Admins\Auth;

use Illuminate\Http\Request;

interface AdminAuthServiceInterface
{
    public function getLoginToken(Request $request): array;

    public function logout(Request $request): array;

    public function addNewAdmin(Request $request): array;

    public function getAdminProfileDetails(Request $request): array;
}

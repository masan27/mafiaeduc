<?php

namespace App\Services\Auth;

use Illuminate\Http\Request;

interface AuthServiceInterface
{
    public function register(Request $request): array;

    public function login(Request $request): array;

    public function logout(Request $request): array;

    public function getUser(Request $request): array;
    
}

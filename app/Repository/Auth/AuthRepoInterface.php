<?php

namespace App\Repository\Auth;

interface AuthRepoInterface
{
    public static function registerUser(string $fullName, string $email, string $password, int $role);

    public static function getUserByEmail(string $email);
}

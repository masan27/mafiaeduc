<?php

namespace App\Repository\Auth;

interface AuthRepoInterface
{
    public static function registerUser(string $fullName, string $email, string $password, int $role);

    public static function getUserByEmail(string $email);

    public static function insertOrUpdateOTP(int $userId, string $otp);

    public static function getUserOtp(int $userId, string $otp);

    public static function deleteUserOtp(int $userId);

    public static function updateUserPassword(int $userId, string $password);
}

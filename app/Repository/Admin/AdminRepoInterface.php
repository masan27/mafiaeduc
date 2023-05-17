<?php

namespace App\Repository\Admin;

interface AdminRepoInterface
{
    public static function getAdminByEmail(string $email);

    public static function getCurrentRememberToken(int $adminId): string;

    public static function updatePassword(int $adminId, string $password): bool;

    public static function updateRememberToken(int $adminId, string $token): bool;

    public static function addNewAdmin(string $fullName, string $email, string $password): bool;
}

<?php

namespace App\Repository\Users;

interface UserRepoInterface
{
    public static function getUserDetailByUserId(int $userId): object;

    public static function getUserFullName(int $userId): string;

    public static function getUserById(int $userId): object;

    public static function changeUserPassword(int $userId, string $newPassword): bool;

    public static function updateUserDetails(int $userId, array $data): bool;
}

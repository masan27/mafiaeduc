<?php

namespace App\Repository\PasswordResetToken;

interface PasswordResetTokenRepoInterface
{
    public static function insertOrUpdateToken(string $email, string $token, string $expiredAt = null): void;

    public static function deleteToken(string $email, string $token): bool;

    public static function checkTokenValid(string $email, string $token): bool;
}

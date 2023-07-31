<?php

namespace App\Repository\PasswordResetToken;

use App\Traits\RepoTrait;
use Illuminate\Support\Facades\DB;

class PasswordResetTokenRepo implements PasswordResetTokenRepoInterface
{
    use RepoTrait;

    private static function getDbTable(): object
    {
        return DB::table('password_reset_tokens');
    }

    public static function insertOrUpdateToken($email, $token, $type, $expiredAt = null): void
    {
        $data = [
            'email' => $email,
            'token' => $token,
            'type' => $type,
            'expired_at' => $expiredAt,
            'created_at' => now(),
        ];

        self::getDbTable()->updateOrInsert(['email' => $email], $data);
    }

    public static function checkTokenValid($email, $token): bool
    {
        return self::getDbTable()
            ->where('email', $email)
            ->where('token', $token)
            ->where('expired_at', '>=', now())
            ->exists();
    }

    public static function deleteToken($email, $token): bool
    {
        return self::getDbTable()
            ->where('email', $email)
            ->where('token', $token)
            ->delete();
    }
}

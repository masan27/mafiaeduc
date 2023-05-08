<?php

namespace App\Repository\AccessLogs;

use App\Traits\RepoTrait;
use Illuminate\Support\Facades\DB;

class AccessLogRepo implements AccessLogRepoInterface
{
    use RepoTrait;

    public static function updateLogoutLogs($userId, $token): void
    {
        self::getDbTable()
            ->where('user_id', $userId)
            ->where('token', $token)
            ->update([
                'logout_at' => now(),
            ]);
    }

    private static function getDbTable()
    {
        return DB::table('access_logs');
    }

    public static function createLoginLogs($userId, $ipAddress, $token): void
    {
        self::getDbTable()->insert([
            'user_id' => $userId,
            'ip_address' => $ipAddress,
            'token' => $token,
            'login_at' => now()
        ]);
    }
}

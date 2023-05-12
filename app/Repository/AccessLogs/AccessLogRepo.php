<?php

namespace App\Repository\AccessLogs;

use App\Traits\RepoTrait;
use Illuminate\Support\Facades\DB;

class AccessLogRepo implements AccessLogRepoInterface
{
    use RepoTrait;

    public static function updateLogoutLogs($loginId, $token, $loginType): void
    {
        self::getDbTable()
            ->where('login_id', $loginId)
            ->where('token', $token)
            ->where('login_type', $loginType)
            ->update([
                'logout_at' => now(),
            ]);
    }

    private static function getDbTable(): object
    {
        return DB::table('access_logs');
    }

    public static function createLoginLogs($loginId, $ipAddress, $token, $loginType): void
    {
        self::getDbTable()->insert([
            'login_id' => $loginId,
            'login_type' => $loginType,
            'ip_address' => $ipAddress,
            'token' => $token,
            'login_at' => now()
        ]);
    }
}

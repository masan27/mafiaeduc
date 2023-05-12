<?php

namespace App\Repository\AccessLogs;

interface AccessLogRepoInterface
{
    public static function createLoginLogs(int $loginId, string $ipAddress, string $token, string $loginType):
    void;

    public static function updateLogoutLogs(int $loginId, string $token, string $loginType): void;
}

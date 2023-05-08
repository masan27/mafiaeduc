<?php

namespace App\Repository\AccessLogs;

interface AccessLogRepoInterface
{
    public static function createLoginLogs(int $userId, string $ipAddress, string $token): void;

    public static function updateLogoutLogs(int $userId, string $token): void;
}

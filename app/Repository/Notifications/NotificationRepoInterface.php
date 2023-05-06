<?php

namespace App\Repository\Notifications;

interface NotificationRepoInterface
{
    public static function getUserNotification(int $userId, int $count);

    public static function createUserNotification(int $userId, string $title, string $body, string $type);

    public static function markNotificationAsRead(int $userId);
}

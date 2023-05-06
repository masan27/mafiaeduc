<?php

namespace App\Repository\Notifications;

use App\Entities\NotificationEntities;
use App\Traits\RepoTrait;
use Illuminate\Support\Facades\DB;

class NotificationRepo implements NotificationRepoInterface
{
    use RepoTrait;

    public static function getUserNotification($userId, $count)
    {
        return self::getDbTable()
            ->where('user_id', $userId)
            ->where('status', NotificationEntities::STATUS_DELIVERED)
            ->orderBy('created_at', 'desc')
            ->select(
                'id',
                'title',
                'body',
                'type',
                'is_read',
                'read_at',
                'created_at',
            )->simplePaginate($count);
    }

    private static function getDbTable()
    {
        return DB::table('notifications');
    }

    public static function createUserNotification($userId, $title, $body, $type)
    {
        return self::getDbTable()->insert([
            'user_id' => $userId,
            'title' => $title,
            'body' => $body,
            'type' => $type,
            'status' => NotificationEntities::STATUS_DELIVERED,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }

    public static function markNotificationAsRead($userId)
    {
        return self::getDbTable()
            ->where('user_id', $userId)
            ->where('status', NotificationEntities::STATUS_DELIVERED)
            ->update([
                'is_read' => NotificationEntities::STATUS_READ,
                'read_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
    }
}

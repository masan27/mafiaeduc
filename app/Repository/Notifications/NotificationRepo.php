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
            ->join('sales', 'sales.id', '=', 'notifications.sales_id')
            ->where('notifications.user_id', $userId)
            ->where('notifications.status', NotificationEntities::STATUS_DELIVERED)
            ->orderBy('notifications.created_at', 'desc')
            ->select(
                'notifications.id',
                'sales_id',
                'sales.sales_status_id as sales_status',
                'notifications.title',
                'notifications.body',
                'notifications.type',
                'notifications.is_read',
                'notifications.read_at',
                'notifications.created_at',
            )->paginate($count);
    }

    private static function getDbTable()
    {
        return DB::table('notifications');
    }

    public static function createUserNotification($userId, $title, $body, $type, $salesId = null)
    {
        return self::getDbTable()->insert([
            'user_id' => $userId,
            'sales_id' => $salesId,
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

<?php

namespace App\Services\Notifications;

use Illuminate\Http\Request;

interface NotificationServiceInterface
{
    public function getUserNotification(Request $request): array;

    public function getNewInfo(Request $request): array;

    public function markNotificationAsRead(Request $request): array;
}

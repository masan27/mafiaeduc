<?php

namespace App\Services\Notifications;

use App\Entities\NotificationEntities;
use App\Helpers\ResponseHelper;
use App\Models\Notifications\Notification;
use App\Repository\Notifications\NotificationRepoInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NotificationService implements NotificationServiceInterface
{
    protected NotificationRepoInterface $notificationRepo;

    public function __construct(NotificationRepoInterface $notificationRepo)
    {
        $this->notificationRepo = $notificationRepo;
    }

    public function getUserNotification($request): array
    {
        try {
            $userId = $request->user()->id;
            $count = $request->input('count', 10);

            $notifications = Notification::where('user_id', $userId)
            ->where('notifications.status', NotificationEntities::STATUS_DELIVERED)
            ->with('sales.detail')->latest()->paginate($count);

            if ($notifications->isEmpty()) return ResponseHelper::notFound('Tidak ada notifikasi');

            return ResponseHelper::success('Berhasil mendapatkan notifikasi', $notifications);
        } catch (\Exception $e) {
            return ResponseHelper::serverError($e->getMessage());
        }
    }

    public function getNewInfo(Request $request): array
    {
        try {
            $userId = $request->user()->id;
            $isUserHasNewNotification = Notification::where('user_id', $userId)
                ->where('is_read', false)
                ->exists();

            if (!$isUserHasNewNotification) return ResponseHelper::success('Tidak ada notifikasi baru', [
                'dots' => false
            ]);

            return ResponseHelper::success('Ada notifikasi baru', [
                'dots' => true
            ]);
        } catch (\Exception $e) {
            return ResponseHelper::serverError($e->getMessage());
        }

    }

    public function markNotificationAsRead($request): array
    {
        DB::beginTransaction();
        try {
            $userId = $request->user()->id;

            $this->notificationRepo->markNotificationAsRead($userId);

            DB::commit();
            return ResponseHelper::success('Berhasil menandai notifikasi');
        } catch (\Exception $e) {
            DB::rollBack();
            return ResponseHelper::serverError($e->getMessage());
        }
    }
}

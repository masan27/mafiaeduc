<?php

namespace App\Services\Notifications;

use App\Helpers\ResponseHelper;
use App\Repository\Notifications\NotificationRepoInterface;
use Illuminate\Support\Facades\DB;

class NotificationService implements NotificationServiceInterface
{
    private NotificationRepoInterface $notificationRepo;

    public function __construct(NotificationRepoInterface $notificationRepo)
    {
        $this->notificationRepo = $notificationRepo;
    }

    public function getUserNotification($request): array
    {
        try {
            $userId = $request->user()->id;
            $count = $request->input('count', 10);

            $notifications = $this->notificationRepo->getUserNotification($userId, $count);

            if ($notifications->isEmpty()) return ResponseHelper::notFound('Tidak ada notifikasi');

            return ResponseHelper::success('Berhasil mendapatkan notifikasi', $notifications);
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

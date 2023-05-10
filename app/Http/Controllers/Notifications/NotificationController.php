<?php

namespace App\Http\Controllers\Notifications;

use App\Http\Controllers\Controller;
use App\Services\Notifications\NotificationServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    protected NotificationServiceInterface $notificationService;

    public function __construct(NotificationServiceInterface $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function getUserNotification(Request $request): JsonResponse
    {
        $data = $this->notificationService->getUserNotification($request);
        return response()->json($data, $data['code']);
    }

    public function markAsRead(Request $request): JsonResponse
    {
        $data = $this->notificationService->markNotificationAsRead($request);
        return response()->json($data, $data['code']);
    }
}

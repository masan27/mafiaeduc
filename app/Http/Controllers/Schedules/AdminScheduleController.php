<?php

namespace App\Http\Controllers\Schedules;

use App\Http\Controllers\Controller;
use App\Services\Admins\Schedules\AdminScheduleServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AdminScheduleController extends Controller
{
    protected AdminScheduleServiceInterface $adminScheduleService;

    public function __construct(AdminScheduleServiceInterface $adminScheduleService)
    {
        $this->adminScheduleService = $adminScheduleService;
    }

    public function getSchedules(int $groupClassId): JsonResponse
    {
        $data = $this->adminScheduleService->getSchedules($groupClassId);
        return response()->json($data, $data['code']);
    }

    public function deleteSchedule(int $scheduleId): JsonResponse
    {
        $data = $this->adminScheduleService->deleteSchedule($scheduleId);
        return response()->json($data, $data['code']);
    }

    public function addSchedule(int $groupClassId, Request $request): JsonResponse
    {
        $data = $this->adminScheduleService->addSchedule($groupClassId, $request);
        return response()->json($data, $data['code']);
    }

    public function editSchedule(int $scheduleId, Request $request): JsonResponse
    {
        $data = $this->adminScheduleService->editSchedule($scheduleId, $request);
        return response()->json($data, $data['code']);
    }
}

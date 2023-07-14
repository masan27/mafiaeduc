<?php

namespace App\Http\Controllers\Schedules;

use App\Http\Controllers\Controller;
use App\Services\Schedules\ScheduleServiceInterface;
use Illuminate\Http\JsonResponse;

class ScheduleController extends Controller
{
    protected ScheduleServiceInterface $scheduleService;

    public function __construct(ScheduleServiceInterface $scheduleService)
    {
        $this->scheduleService = $scheduleService;
    }

    public function getUserSchedules(): JsonResponse
    {
        $data = $this->scheduleService->getUserSchedules();
        return response()->json($data, $data['code']);
    }
}

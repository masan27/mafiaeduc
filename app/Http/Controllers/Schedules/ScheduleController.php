<?php

namespace App\Http\Controllers\Schedules;

use App\Http\Controllers\Controller;
use App\Services\Schedules\ScheduleServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    protected ScheduleServiceInterface $scheduleService;

    public function __construct(ScheduleServiceInterface $scheduleService)
    {
        $this->scheduleService = $scheduleService;
    }

    public function getUserSchedules(Request $request): JsonResponse
    {
        $data = $this->scheduleService->getUserSchedules($request);
        return response()->json($data, $data['code']);
    }
}

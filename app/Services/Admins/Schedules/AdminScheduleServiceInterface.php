<?php

namespace App\Services\Admins\Schedules;

use Illuminate\Http\Request;

interface AdminScheduleServiceInterface
{
    public function getSchedules(int $groupClassId): array;

    public function deleteSchedule(int $scheduleId): array;

    public function addSchedule(int $groupClassId, Request $request): array;

    public function editSchedule(int $scheduleId, Request $request): array;
}

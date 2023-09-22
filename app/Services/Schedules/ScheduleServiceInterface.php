<?php

namespace App\Services\Schedules;

use Illuminate\Http\Request;

interface ScheduleServiceInterface
{
    public function getUserSchedules(Request $request): array;
}

<?php

namespace App\Services\Mentors\Schedules;

use Illuminate\Http\Request;

interface MentorScheduleServiceInterface
{
    public function getMentorSchedules(int $privateClassId, Request $request): array;

    public function addMentorSchedule(int $privateClassId, Request $request): array;

    public function editMentorSchedule(int $scheduleId, Request $request): array;

    public function deleteMentorSchedule(int $scheduleId): array;

    public function getRecentSchedules(Request $request): array;

    public function doneMentorSchedule(int $scheduleId, Request $request): array;
}

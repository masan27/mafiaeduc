<?php

namespace App\Services\Mentors\Schedules;

use Illuminate\Http\Request;

interface MentorScheduleInterface
{
    public function getMentorSchedules(int $privateClassId, Request $request): array;

    public function addMentorSchedule(int $privateClassId, Request $request): array;

    public function editMentorSchedule(int $scheduleId, Request $request): array;

    public function deleteMentorSchedule(int $scheduleId): array;
}

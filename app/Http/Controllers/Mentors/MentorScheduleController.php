<?php

namespace App\Http\Controllers\Mentors;

use App\Http\Controllers\Controller;
use App\Services\Mentors\Schedules\MentorScheduleInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MentorScheduleController extends Controller
{
    protected MentorScheduleInterface $mentorSchedule;

    public function __construct(MentorScheduleInterface $mentorSchedule)
    {
        $this->mentorSchedule = $mentorSchedule;
    }

    public function getMentorSchedules(int $privateClassId, Request $request): JsonResponse
    {
        $data = $this->mentorSchedule->getMentorSchedules($privateClassId, $request);
        return response()->json($data, $data['code']);
    }

    public function addMentorSchedule(int $privateClassId, Request $request): JsonResponse
    {
        $data = $this->mentorSchedule->addMentorSchedule($privateClassId, $request);
        return response()->json($data, $data['code']);
    }

    public function editMentorSchedule(int $scheduleId, Request $request): JsonResponse
    {
        $data = $this->mentorSchedule->editMentorSchedule($scheduleId, $request);
        return response()->json($data, $data['code']);
    }

    public function deleteMentorSchedule(int $scheduleId): JsonResponse
    {
        $data = $this->mentorSchedule->deleteMentorSchedule($scheduleId);
        return response()->json($data, $data['code']);
    }
}

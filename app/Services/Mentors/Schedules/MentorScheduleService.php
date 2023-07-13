<?php

namespace App\Services\Mentors\Schedules;

use App\Helpers\ResponseHelper;
use App\Models\Classes\PrivateClass;
use App\Models\Schedules\Schedule;
use App\Validators\ScheduleValidator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MentorScheduleService implements MentorScheduleInterface
{
    protected ScheduleValidator $scheduleValidator;

    public function __construct(ScheduleValidator $scheduleValidator)
    {
        $this->scheduleValidator = $scheduleValidator;
    }

    public function getMentorSchedules(int $privateClassId, Request $request): array
    {
        try {
            $mentorId = $request->mentor->mentor_id;

            $privateClass = PrivateClass::find($privateClassId);

            if (!$privateClass) return ResponseHelper::notFound('Kelas privat tidak ditemukan');

//            if($privateClass->status == 0) return ResponseHelper::notFound('Kelas privat tidak aktif');

            $schedules = Schedule::where([
                ['private_classes_id', $privateClassId],
                ['mentor_id', $mentorId]
            ])->get();

            if ($schedules->isEmpty()) return ResponseHelper::notFound('Jadwal tidak ditemukan');

            return ResponseHelper::success('Berhasil mendapatkan jadwal mentor', $schedules);
        } catch (\Exception $e) {
            return ResponseHelper::serverError($e->getMessage());
        }

    }

    public function addMentorSchedule(int $privateClassId, Request $request): array
    {
        $validator = $this->scheduleValidator->validateCreateMentorPrivateClassSchedules($request);

        if ($validator) return $validator;

        DB::beginTransaction();
        try {
            $privateClass = PrivateClass::find($privateClassId);

            if (!$privateClass) return ResponseHelper::notFound('Kelas privat tidak ditemukan');

//            if ($privateClass->status == 0) return ResponseHelper::notFound('Kelas privat tidak aktif');

            $mentorId = $request->mentor->mentor_id;
            $meetingLink = $request->input('meeting_link');
            $meetingPlatform = $request->input('meeting_platform');
            $date = $request->input('date');
            $time = $request->input('time');

            $schedule = Schedule::create([
                'private_classes_id' => $privateClassId,
                'learning_method_id' => $privateClass->learning_method_id,
                'grade_id' => $privateClass->grade_id,
                'subject_id' => $privateClass->subject_id,
                'mentor_id' => $mentorId,
                'meeting_link' => $meetingLink,
                'meeting_platform' => $meetingPlatform,
                'date' => $date,
                'time' => $time,
            ]);

            if (!$schedule) return ResponseHelper::error('Gagal menambahkan jadwal');

            DB::commit();
            return ResponseHelper::success('Berhasil menambahkan jadwal', $schedule);
        } catch (\Exception $e) {
            DB::rollBack();
            return ResponseHelper::serverError($e->getMessage());
        }

    }

    public function editMentorSchedule(int $scheduleId, Request $request): array
    {
        DB::beginTransaction();
        try {
            $validator = $this->scheduleValidator->validateEditMentorPrivateClassSchedules($request);

            if ($validator) return $validator;

            DB::beginTransaction();
            $meetingLink = $request->input('meeting_link');
            $meetingPlatform = $request->input('meeting_platform');
            $date = $request->input('date');
            $time = $request->input('time');

            $schedule = Schedule::find($scheduleId);

            if (!$schedule) return ResponseHelper::notFound('Jadwal tidak ditemukan');

            $schedule->update([
                'meeting_link' => $meetingLink,
                'meeting_platform' => $meetingPlatform,
                'date' => $date,
                'time' => $time,
            ]);

            DB::commit();
            return ResponseHelper::success('Berhasil merubah jadwal', $schedule);
        } catch (\Exception $e) {
            DB::rollBack();
            return ResponseHelper::serverError($e->getMessage());
        }
    }

    public function deleteMentorSchedule(int $scheduleId): array
    {
        DB::beginTransaction();
        try {
            $schedule = Schedule::find($scheduleId);

            if (!$schedule) return ResponseHelper::notFound('Jadwal tidak ditemukan');

            $schedule->delete();

            DB::commit();
            return ResponseHelper::success('Berhasil menghapus jadwal');
        } catch (\Exception $e) {
            DB::rollBack();
            return ResponseHelper::serverError($e->getMessage());
        }

    }
}

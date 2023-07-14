<?php

namespace App\Services\Admins\Schedules;

use App\Helpers\ResponseHelper;
use App\Models\Classes\GroupClass;
use App\Models\Schedules\Schedule;
use App\Validators\ScheduleValidator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminScheduleService implements AdminScheduleServiceInterface
{
    protected ScheduleValidator $scheduleValidator;

    public function __construct(ScheduleValidator $scheduleValidator)
    {
        $this->scheduleValidator = $scheduleValidator;
    }

    public function getSchedules(int $groupClassId): array
    {
        try {
            $Schedules = Schedule::with('learningMethod')->where('group_classes_id', $groupClassId)->get();

            if ($Schedules->isEmpty()) {
                return ResponseHelper::notFound('Jadwal kelas belajar tidak ditemukan');
            }

            return ResponseHelper::success('Berhasil mendapatkan data jadwal kelas belajar', $Schedules);
        } catch (\Exception $e) {
            return ResponseHelper::serverError($e->getMessage());
        }
    }

    public function deleteSchedule(int $scheduleId): array
    {
        DB::beginTransaction();
        try {
            $schedule = Schedule::find($scheduleId);

            if (!$schedule) {
                return ResponseHelper::notFound('Jadwal kelas belajar tidak ditemukan');
            }

            $schedule->delete();

            DB::commit();
            return ResponseHelper::success('Berhasil menghapus jadwal kelas belajar');
        } catch (\Exception $e) {
            DB::rollBack();
            return ResponseHelper::serverError($e->getMessage());
        }

    }

    public function addSchedule(int $groupClassId, Request $request): array
    {
        $validator = $this->scheduleValidator->validateCreateGroupClassSchedules($request);

        if ($validator) return $validator;

        DB::beginTransaction();
        try {
            $mentorId = $request->input('mentor_id');
            $meetingLink = $request->input('meeting_link');
            $meetingPlatform = $request->input('meeting_platform');
            $date = $request->input('date');
            $time = $request->input('time');
            $address = $request->input('address');
            $groupClass = GroupClass::find($groupClassId);

            if (!$groupClass) {
                return ResponseHelper::notFound('Kelas belajar tidak ditemukan');
            }

            $schedule = Schedule::create([
                'group_classes_id' => $groupClassId,
                'learning_method_id' => $groupClass->learning_method_id,
                'grade_id' => $groupClass->grade_id,
                'subject_id' => $groupClass->subject_id,
                'mentor_id' => $mentorId,
                'meeting_link' => $meetingLink,
                'meeting_platform' => $meetingPlatform,
                'address' => $address,
                'date' => $date,
                'time' => $time,
            ]);

            if (!$schedule) {
                return ResponseHelper::error('Gagal menambahkan jadwal kelas belajar');
            }

            DB::commit();
            return ResponseHelper::success();
        } catch (\Exception $e) {
            DB::rollBack();
            return ResponseHelper::serverError($e->getMessage());
        }
    }

    public function editSchedule(int $scheduleId, Request $request): array
    {
        $validator = $this->scheduleValidator->validateEditGroupClassSchedules($request);

        if ($validator) return $validator;

        DB::beginTransaction();
        try {
            $mentorId = $request->input('mentor_id');
            $meetingLink = $request->input('meeting_link');
            $meetingPlatform = $request->input('meeting_platform');
            $date = $request->input('date');
            $time = $request->input('time');
            $address = $request->input('address');

            $schedule = Schedule::find($scheduleId);

            if (!$schedule) return ResponseHelper::notFound('Jadwal tidak ditemukan');

            $schedule->update([
                'mentor_id' => $mentorId,
                'address' => $address,
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
}

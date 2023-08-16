<?php

namespace App\Services\Mentors\Schedules;

use App\Entities\SalesEntities;
use App\Helpers\ResponseHelper;
use App\Models\Classes\PrivateClass;
use App\Models\Mentors\Mentor;
use App\Models\Schedules\Schedule;
use App\Validators\ScheduleValidator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MentorScheduleService implements MentorScheduleServiceInterface
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
            $count = $request->input('count', 10);

            $privateClass = PrivateClass::find($privateClassId);

            if (!$privateClass) return ResponseHelper::notFound('Kelas privat tidak ditemukan');

            $schedules = Schedule::with('learningMethod')
                ->where([
                    ['private_classes_id', $privateClassId],
                    ['mentor_id', $mentorId]
                ])
                ->orderBy('date', 'asc')
                ->paginate($count);

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

            // check if the private class has been booked by students in sales_detail table
            $isBooked = DB::table('sales_details')
                ->join('sales', 'sales_details.sales_id', '=', 'sales.id')
                ->where([
                    ['private_classes_id', $privateClassId],
                    ['sales.sales_status_id', SalesEntities::SALES_STATUS_PAID],
                ])->exists();

            if ($isBooked) {
                // add user_id to the user_schedule table
                $users = DB::table('sales_details')
                    ->join('sales', 'sales_details.sales_id', '=', 'sales.id')
                    ->where([
                        ['private_classes_id', $privateClassId],
                        ['sales.sales_status_id', SalesEntities::SALES_STATUS_PAID],
                    ])->get();

                foreach ($users as $user) {
                    DB::table('user_schedule')->insert([
                        'user_id' => $user->user_id,
                        'schedule_id' => $schedule->id,
                    ]);
                }
            }

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

            // check if the private class has been booked by students in sales_detail table
            $isBooked = DB::table('user_schedule')
                ->where('schedule_id', $scheduleId)
                ->exists();

            if ($isBooked) {
                // delete user_id from the user_schedule table
                DB::table('user_schedule')
                    ->where('schedule_id', $scheduleId)
                    ->delete();
            }

            $schedule->delete();

            DB::commit();
            return ResponseHelper::success('Berhasil menghapus jadwal');
        } catch (\Exception $e) {
            DB::rollBack();
            return ResponseHelper::serverError($e->getMessage());
        }

    }

    public function getRecentSchedules(Request $request): array
    {
        try {
            $mentorId = $request->mentor->mentor_id;
            $count = $request->input('count', 10);

            $mentor = Mentor::find($mentorId);

            if (!$mentor) return ResponseHelper::notFound('Mentor tidak ditemukan');

            // get the last schedules of the mentor that has been booked by students and has not been completed
            $schedules = Schedule::with('learningMethod', 'users.detail', 'subject', 'grade')
                ->whereHas('users')
                ->where([
                    ['mentor_id', $mentorId],
                    ['is_done', false],
                ])->orderBy('date', 'asc')
                ->paginate($count);

            if ($schedules->isEmpty()) return ResponseHelper::notFound('Jadwal tidak ditemukan');

            return ResponseHelper::success('Berhasil mendapatkan jadwal mentor', $schedules);
        } catch (\Exception $e) {
            return ResponseHelper::serverError($e->getMessage());
        }

    }
}

<?php

namespace App\Services\Schedules;

use App\Helpers\FileHelper;
use App\Helpers\ResponseHelper;
use App\Models\Schedules\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScheduleService implements ScheduleServiceInterface
{
    public function getUserSchedules(Request $request): array
    {
        try {
            $userId = Auth::id();
            $learningMethod = $request->query('learning_method');

            $schedules = Schedule::with('mentor:id,full_name,phone,photo', 'grade', 'subject', 'learningMethod', 'privateClass', 'groupClass')
                ->whereHas('users', function ($query) use ($userId) {
                    $query->where('user_id', $userId);
                })
                ->when($learningMethod, function ($query, $learningMethod) {
                    $query->where('learning_method_id', $learningMethod);
                })
                ->orderBy('date', 'desc')
                ->get();

            if ($schedules->isEmpty()) return ResponseHelper::notFound('Data jadwal tidak ditemukan');

            foreach ($schedules as $schedule) {
                $schedule->mentor->photo = FileHelper::getFileUrl($schedule->mentor->photo);
            }

            return ResponseHelper::success('Berhasil jadwal user', $schedules);
        } catch (\Exception $e) {
            return ResponseHelper::serverError($e->getMessage());
        }

    }
}

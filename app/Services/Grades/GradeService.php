<?php

namespace App\Services\Grades;

use App\Helpers\ResponseHelper;
use App\Models\Grades\Grade;

class GradeService implements GradeServiceInterface
{
    public function getGrades(): array
    {
        try {
            $grades = Grade::all();

            if ($grades->isEmpty()) {
                return ResponseHelper::notFound('Grades not found');
            }

            return ResponseHelper::success('Berhasil mendapatkan data grade', $grades);
        } catch (\Exception $e) {
            return ResponseHelper::serverError($e->getMessage());
        }

    }
}

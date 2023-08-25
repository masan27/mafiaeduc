<?php

namespace App\Services\Grades;

use App\Helpers\ResponseHelper;
use App\Models\Grades\Grade;
use Illuminate\Http\Request;

class GradeService implements GradeServiceInterface
{
    public function getGrades(Request $request): array
    {
        try {
            $search = $request->query('search');
            $grades = Grade::when($search, function ($q) use ($search) {
                $q->where('name', 'like', "%$search%");
            })->get();

            if ($grades->isEmpty()) {
                return ResponseHelper::notFound('Grades not found');
            }

            return ResponseHelper::success('Berhasil mendapatkan data grade', $grades);
        } catch (\Exception $e) {
            return ResponseHelper::serverError($e->getMessage());
        }

    }
}

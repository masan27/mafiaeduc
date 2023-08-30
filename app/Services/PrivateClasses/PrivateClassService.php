<?php

namespace App\Services\PrivateClasses;

use App\Entities\MentorEntities;
use App\Helpers\ResponseHelper;
use App\Models\Classes\PrivateClass;
use Illuminate\Http\Request;

class PrivateClassService implements PrivateClassServiceInterface
{
    public function getAllPrivateClasses(Request $request): array
    {
        try {
            $gradeId = $request->input('grade');
            $subjectId = $request->input('subject');
            $learningMethodId = $request->input('learning_method');
            $sortPrice = $request->input('sort_price');
            $search = $request->input('search');

            switch ($sortPrice) {
                case 'asc':
                    $sortPrice = 'asc';
                    break;
                case 'desc':
                    $sortPrice = 'desc';
                    break;
                default:
                    $sortPrice = null;
                    break;
            }

            $privateClasses = PrivateClass::active()
                ->with('learningMethod', 'grade', 'subject', 'mentor:id,full_name,photo,phone')
                ->whereHas('mentor', function ($q) {
                    return $q->where('status', MentorEntities::MENTOR_STATUS_APPROVED);
                })
                ->when($subjectId, function ($query, $subjectId) {
                    return $query->where('subject_id', $subjectId);
                })
                ->when($gradeId, function ($query, $gradeId) {
                    return $query->where('grade_id', $gradeId);
                })
                ->when($learningMethodId, function ($query, $learningMethodId) {
                    return $query->where('learning_method_id', $learningMethodId);
                })
                ->when($sortPrice, function ($query, $sortPrice) {
                    return $query->orderBy('price', $sortPrice);
                })
                ->when($search, function ($query, $search) {
                    return $query->where('price', 'like', "%$search%")
                        ->orWhere('address', 'like', "%$search%")
                        ->orWhereHas('mentor', function ($query) use ($search) {
                            $query->where('full_name', 'like', "%$search%");
                        })
                        ->orWhereHas('subject', function ($query) use ($search) {
                            $query->where('name', 'like', "%$search%");
                        })
                        ->orWhereHas('grade', function ($query) use ($search) {
                            $query->where('name', 'like', "%$search%");
                        })
                        ->orWhereHas('learningMethod', function ($query) use ($search) {
                            $query->where('name', 'like', "%$search%");
                        })
                        ->orWhere('description', 'like', "%$search%");
                })
                ->get();

            if ($privateClasses->isEmpty()) return ResponseHelper::notFound('Data kelas tidak ditemukan');

            return ResponseHelper::success('Berhasil mendapatkan data kelas', $privateClasses);
        } catch (\Exception $e) {
            return ResponseHelper::serverError($e->getMessage());
        }
    }

    public function getPrivateClassDetails(int $privateClassId, Request $request): array
    {
        try {
            $privateClass = PrivateClass::active()
                ->with('learningMethod', 'grade', 'subject', 'mentor:id,full_name,photo,phone')
                ->where('id', $privateClassId)
                ->first();

            if (!$privateClass) return ResponseHelper::error('Kelas tidak ditemukan');

            return ResponseHelper::success('Berhasil mendapatkan data kelas belajar', $privateClass);
        } catch (\Exception $e) {
            return ResponseHelper::serverError($e->getMessage());
        }

    }
}

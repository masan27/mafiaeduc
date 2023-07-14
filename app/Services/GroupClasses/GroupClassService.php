<?php

namespace App\Services\GroupClasses;

use App\Helpers\ResponseHelper;
use App\Models\Classes\GroupClass;
use Illuminate\Http\Request;

class GroupClassService implements GroupClassServiceInterface
{
    public function getAllGroupClasses(Request $request): array
    {
        try {
            $gradeId = $request->input('grade');
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

            $groupClasses = GroupClass::active()
                ->with('learningMethod', 'grade', 'subject')
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
                    return $query->where('title', 'like', "%$search%")
                        ->orWhere('price', 'like', "%$search%")
                        ->orWhereHas('grade', function ($query) use ($search) {
                            $query->where('name', 'like', "%$search%");
                        })
                        ->orWhereHas('subject', function ($query) use ($search) {
                            $query->where('name', 'like', "%$search%");
                        })
                        ->orWhereHas('learningMethod', function ($query) use ($search) {
                            $query->where('name', 'like', "%$search%");
                        })
                        ->orWhere('description', 'like', "%$search%")
                        ->orWhere('additional_info', 'like', "%$search%");
                })
                ->get();

            if ($groupClasses->isEmpty()) return ResponseHelper::notFound('Data kelas tidak ditemukan');

            return ResponseHelper::success('Berhasil mendapatkan data kelas', $groupClasses);
        } catch (\Exception $e) {
            return ResponseHelper::serverError($e->getMessage());
        }
    }

    public function getGroupClassDetails(int $groupClassId, Request $request): array
    {
        try {
            $groupClass = GroupClass::active()
                ->with('learningMethod', 'grade', 'subject')
                ->where('id', $groupClassId)
                ->get();

            if (!$groupClass) return ResponseHelper::error('Kelas tidak ditemukan');

            return ResponseHelper::success('Berhasil mendapatkan data kelas belajar', $groupClass);
        } catch (\Exception $e) {
            return ResponseHelper::serverError($e->getMessage());
        }

    }
}

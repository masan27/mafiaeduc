<?php

namespace App\Services\Admins\GroupClasses;

use App\Helpers\ResponseHelper;
use App\Models\Classes\GroupClass;
use App\Validators\GroupClassValidator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminGroupClassesService implements AdminGroupClassesInterface
{

    protected GroupClassValidator $groupClassValidator;

    public function __construct(GroupClassValidator $groupClassValidator)
    {
        $this->groupClassValidator = $groupClassValidator;
    }

    public function getAllGroupClasses(Request $request): array
    {
        try {
            $search = $request->query('search');
            $count = $request->query('count', 10);
            $groupClasses = GroupClass::with('subject', 'learningMethod', 'grade')
                ->when($search, function ($query) use ($search) {
                    $query->where('title', 'like', "%$search%")
                        ->orWhere('price', 'like', "%$search%")
                        ->orWhereHas('subject', function ($query) use ($search) {
                            $query->where('name', 'like', "%$search%");
                        })
                        ->orWhereHas('learningMethod', function ($query) use ($search) {
                            $query->where('name', 'like', "%$search%");
                        })
                        ->orWhereHas('grade', function ($query) use ($search) {
                            $query->where('name', 'like', "%$search%");
                        });
                })
                ->paginate($count);

            if ($groupClasses->isEmpty()) return ResponseHelper::notFound('Kelas grup tidak ditemukan');

            return ResponseHelper::success('Berhasil mendapatkan kelas grup', $groupClasses);
        } catch (\Exception $e) {
            return ResponseHelper::serverError($e->getMessage());
        }

    }

    public function deleteGroupClass(int $groupClassId): array
    {
        DB::beginTransaction();
        try {
            $groupClass = GroupClass::find($groupClassId);

            if (!$groupClass) return ResponseHelper::notFound('Kelas grup tidak ditemukan');

            $groupClass->delete();

            DB::commit();
            return ResponseHelper::success('Berhasil menghapus kelas grup');
        } catch (\Exception $e) {
            DB::rollBack();
            return ResponseHelper::serverError($e->getMessage());
        }

    }

    public function updateStatusGroupClass(int $groupClassId, Request $request): array
    {
        $validator = $this->groupClassValidator->validateChangeGroupClasses($request);

        if ($validator) return $validator;

        DB::beginTransaction();
        try {
            $groupClass = GroupClass::find($groupClassId);
            $status = $request->input('status');

            if (!$groupClass) return ResponseHelper::notFound('Kelas grup tidak ditemukan');

            $groupClass->status = $status;
            $groupClass->save();

            DB::commit();
            return ResponseHelper::success('Berhasil merubah status kelas grup');
        } catch (\Exception $e) {
            DB::rollBack();
            return ResponseHelper::serverError($e->getMessage());
        }

    }

    public function addGroupClass(Request $request): array
    {
        $validator = $this->groupClassValidator->validateCreateGroupClasses($request);

        if ($validator) return $validator;

        DB::beginTransaction();
        try {
            $title = $request->input('title');
            $description = $request->input('description');
            $subjectId = $request->input('subject_id');
            $learningMethodId = $request->input('learning_method_id');
            $gradeId = $request->input('grade_id');
            $price = $request->input('price');
            $additionalInfo = $request->input('additional_info');

            $groupClass = GroupClass::create([
                'title' => $title,
                'description' => $description,
                'subject_id' => $subjectId,
                'learning_method_id' => $learningMethodId,
                'grade_id' => $gradeId,
                'price' => $price,
                'additional_info' => $additionalInfo,
            ]);

            if (!$groupClass) return ResponseHelper::serverError('Gagal menambahkan kelas grup');

            DB::commit();
            return ResponseHelper::success('Berhasil menambahkan kelas grup');
        } catch (\Exception $e) {
            DB::rollBack();
            return ResponseHelper::serverError($e->getMessage());
        }
    }

    public function updateGroupClass(int $groupClassId, Request $request): array
    {
        $validator = $this->groupClassValidator->validateUpdateGroupClasses($request);

        if ($validator) return $validator;

        DB::beginTransaction();
        try {
            $groupClass = GroupClass::find($groupClassId);

            if (!$groupClass) return ResponseHelper::notFound('Kelas grup tidak ditemukan');

            $groupClass->update($request->all());

            DB::commit();
            return ResponseHelper::success('Berhasil merubah kelas grup');
        } catch (\Exception $e) {
            DB::rollBack();
            return ResponseHelper::serverError($e->getMessage());
        }

    }

    public function getGroupClassDetails(int $groupClassId): array
    {
        try {
            $groupClass = GroupClass::with('subject', 'learningMethod', 'grade', 'schedules')->find
            ($groupClassId);

            if (!$groupClass) return ResponseHelper::notFound('Kelas grup tidak ditemukan');

            return ResponseHelper::success('Berhasil mendapatkan detail kelas grup', $groupClass);
        } catch (\Exception $e) {
            return ResponseHelper::serverError($e->getMessage());
        }

    }
}

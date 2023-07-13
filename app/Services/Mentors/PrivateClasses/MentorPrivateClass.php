<?php

namespace App\Services\Mentors\PrivateClasses;

use App\Helpers\ResponseHelper;
use App\Models\Classes\PrivateClass;
use App\Validators\PrivateClassValidator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MentorPrivateClass implements MentorPrivateClassInterface
{

    protected PrivateClassValidator $privateClassValidator;

    public function __construct(PrivateClassValidator $privateClassValidator)
    {
        $this->privateClassValidator = $privateClassValidator;
    }

    public function getMentorPrivateClasses(Request $request): array
    {
        try {
            $mentorId = $request->mentor->id;
            $privateClasses = PrivateClass::with('subject', 'learningMethod', 'grade')
                ->where('mentor_id', $mentorId)
                ->get();

            if ($privateClasses->isEmpty()) return ResponseHelper::notFound('Tiada kelas privat');

            return ResponseHelper::success('Berhasil mendapatkan data kelas privat', $privateClasses);
        } catch (\Exception $e) {
            return ResponseHelper::serverError($e->getMessage());
        }
    }

    public function deleteMentorPrivateClass(int $privateClassId): array
    {
        DB::beginTransaction();
        try {
            $privateClass = PrivateClass::find($privateClassId);

            if (!$privateClass) return ResponseHelper::notFound('Kelas privat tidak ditemukan');

            $privateClass->delete();

            DB::commit();
            return ResponseHelper::success('Berhasil menghapus kelas privat');
        } catch (\Exception $e) {
            DB::rollBack();
            return ResponseHelper::serverError($e->getMessage());
        }

    }

    public function addMentorPrivateClass(Request $request): array
    {
        $validator = $this->privateClassValidator->validateCreateMentorPrivateClasses($request);

        if ($validator) return $validator;

        DB::beginTransaction();
        try {
            $mentorId = $request->mentor->id;
            $subjectId = $request->input('subject_id');
            $gradeId = $request->input('grade_id');
            $learningMethodId = $request->input('learning_method_id');
            $description = $request->input('description');
            $address = $request->input('address');
            $price = $request->input('price');
            $totalSlot = $request->input('total_slot');

            $privateClass = PrivateClass::create([
                'mentor_id' => $mentorId,
                'subject_id' => $subjectId,
                'grade_id' => $gradeId,
                'learning_method_id' => $learningMethodId,
                'description' => $description,
                'address' => $address,
                'price' => $price,
                'total_slot' => $totalSlot,
            ]);

            if (!$privateClass) return ResponseHelper::serverError('Gagal membuat kelas privat');

            DB::commit();
            return ResponseHelper::success('Berhasil memposting kelas privat', $privateClass);
        } catch (\Exception $e) {
            DB::rollBack();
            return ResponseHelper::serverError($e->getMessage());
        }
    }

    public function editMentorPrivateClass(int $privateClassId, Request $request): array
    {
        $validator = $this->privateClassValidator->validateEditMentorPrivateClasses($request);

        if ($validator) return $validator;

        DB::beginTransaction();
        try {
            $privateClass = PrivateClass::find($privateClassId);

            if (!$privateClass) return ResponseHelper::notFound('Kelas privat tidak ditemukan');

            $privateClass->update($request->all());

            DB::commit();
            return ResponseHelper::success('Berhasil mengubah kelas privat', $privateClass);
        } catch (\Exception $e) {
            DB::rollBack();
            return ResponseHelper::serverError($e->getMessage());
        }
    }


    public function changeMentorPrivateClassStatus(int $privateClassId, Request $request): array
    {
        $validator = $this->privateClassValidator->validateChangeMentorPrivateClassStatus($request);

        if ($validator) return $validator;

        DB::beginTransaction();
        try {
            $privateClass = PrivateClass::find($privateClassId);
            $status = $request->input('status');

            if (!$privateClass) return ResponseHelper::notFound('Kelas privat tidak ditemukan');

            $privateClass->status = $status;
            $privateClass->save();

            DB::commit();
            return ResponseHelper::success('Berhasil mengubah status kelas privat', $privateClass);
        } catch (\Exception $e) {
            return ResponseHelper::serverError($e->getMessage());
        }

    }

    public function getMentorPrivateClassDetails(int $privateClassId): array
    {
        try {
            $privateClass = PrivateClass::with('subject', 'learningMethod', 'grade', 'schedules:id,private_classes_id,meeting_link,meeting_platform,address,date,time')
                ->where('id', $privateClassId)
                ->first();

            if (!$privateClass) return ResponseHelper::notFound('Kelas privat tidak ditemukan');

            return ResponseHelper::success('Berhasil mendapatkan detail kelas privat', $privateClass);
        } catch (\Exception $e) {
            return ResponseHelper::serverError($e->getMessage());
        }

    }
}

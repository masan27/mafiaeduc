<?php

namespace App\Services\Mentors;

use App\Helpers\FileHelper;
use App\Helpers\ResponseHelper;
use App\Repository\Mentors\MentorRepoInterface;
use App\Validators\MentorValidator;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MentorService implements MentorServiceInterface
{
    protected MentorRepoInterface $mentorRepo;

    protected MentorValidator $mentorValidator;

    public function __construct(MentorRepoInterface $mentorRepo, MentorValidator $mentorValidator)
    {
        $this->mentorRepo = $mentorRepo;
        $this->mentorValidator = $mentorValidator;
    }

    public function registerMentor($request): array
    {
        $validator = $this->mentorValidator->validateRegisterMentorInput($request);

        if ($validator) return $validator;

        DB::beginTransaction();
        try {
            $userId = $request->user()->id;
            $learningMethodId = $request->input('learning_method_id');
            $gradeId = $request->input('grade_id');
            $fullName = $request->input('full_name');
            $photo = $request->file('photo');
            $certificate = $request->file('certificate');
            $identityCard = $request->file('identity_card');
            $cv = $request->file('cv');
            $teachingVideo = $request->input('teaching_video');
            $phone = $request->input('phone');
            $salary = $request->input('salary');
            $linkedin = $request->input('linkedin');
            $subjects = (array)$request->input('subjects');

            $canSendProposal = $this->mentorRepo->checkMentorCanRegister($userId);

            if (!$canSendProposal) return ResponseHelper::error('Lamaran anda sedang diproses');

            if (count($subjects) > 3) return ResponseHelper::error('Mata pelajaran tidak boleh lebih dari 3');

            $folderPath = 'mentors/' . $userId . '-' . Carbon::now()->timestamp;

            $photoPath = FileHelper::uploadFile($photo, $folderPath, 'photo');
            $certificatePath = FileHelper::uploadFile($certificate, $folderPath, 'certificate');
            $identityCardPath = FileHelper::uploadFile($identityCard, $folderPath, 'identity_card');
            $cvPath = FileHelper::uploadFile($cv, $folderPath, 'cv');

            $registerData = [
                'user_id' => $userId,
                'learning_method_id' => $learningMethodId,
                'grade_id' => $gradeId,
                'full_name' => $fullName,
                'photo' => $photoPath,
                'certificate' => $certificatePath,
                'identity_card' => $identityCardPath,
                'cv' => $cvPath,
                'teaching_video' => $teachingVideo,
                'phone' => $phone,
                'salary' => $salary,
                'linkedin' => $linkedin,
            ];

            $mentorId = $this->mentorRepo->registerMentor(...$registerData);

            foreach ($subjects as $subject) {
                $this->mentorRepo->insertMentorSubject($mentorId, $subject);
            }

            DB::commit();

            return ResponseHelper::success('Lamaran mentor berhasil dikirim');
        } catch (\Exception $e) {
            DB::rollBack();
            return ResponseHelper::serverError($e->getMessage());
        }
    }

    public function acceptMentorApplication($request): array
    {
        $validator = $this->mentorValidator->validateMentorId($request);

        if ($validator) return $validator;

        DB::beginTransaction();
        try {
            $mentorId = $request->input('mentor_id');
            $mentor = $this->mentorRepo->getMentorById($mentorId);

            if (!$mentor) return ResponseHelper::notFound('Mentor tidak ditemukan');

            if ($mentor->status == 1) return ResponseHelper::error('Lamaran mentor sudah diterima');

            $this->mentorRepo->acceptMentorApplication($mentorId);

            $mentorEmail = $mentor->email;

            $mentorPassword = self::generateRandomPassword(6);
            $mentorApiToken = self::generateApiToken($mentorId, $mentorEmail);

            $this->mentorRepo->createMentorCredential($mentorId, $mentorEmail,
                $mentorPassword, $mentorApiToken);

            $mentorAuthData = [
                'mentor_id' => $mentorId,
                'email' => $mentorEmail,
                'password' => $mentorPassword,
            ];

            DB::commit();
            return ResponseHelper::success('Lamaran mentor berhasil diterima', $mentorAuthData);
        } catch (\Exception $e) {
            DB::rollBack();
            return ResponseHelper::serverError($e->getMessage());
        }
    }

    private function generateApiToken($mentorId, $mentorEmail): string
    {
        return md5($mentorId . $mentorEmail . Carbon::now()->timestamp);
    }

    private function generateRandomPassword(int $length = 8): string
    {
        return strtoupper(Str::password($length, true, true, false));
    }

    public function getAllMentors(): array
    {
        try {
            $mentors = $this->mentorRepo->getAllMentors();

            if ($mentors->isEmpty()) return ResponseHelper::notFound('Mentor tidak ditemukan');

            foreach ($mentors as $mentor) {
                $this->getMentorFile($mentor);
            }

            return ResponseHelper::success('Berhasil mengambil data mentor', $mentors);
        } catch (\Exception $e) {
            return ResponseHelper::serverError($e->getMessage());
        }
    }

    public function getMentorDetails($mentorId): array
    {
        try {
            $mentor = $this->mentorRepo->getMentorById($mentorId);

            if (!$mentor) return ResponseHelper::notFound('Mentor tidak ditemukan');

            $this->getMentorFile($mentor);

            $mentor->account = $this->mentorRepo->getMentorCredentials($mentorId);

            return ResponseHelper::success('Berhasil mengambil data mentor', $mentor);
        } catch (\Exception $e) {
            return ResponseHelper::serverError($e->getMessage());
        }
    }

    /**
     * @param object $mentor
     * @return void
     */
    private function getMentorFile(object $mentor): void
    {
        $mentor->subjects = $this->mentorRepo->getMentorSubjects($mentor->id);
        $mentor->photo = url(Storage::url($mentor->photo));
        $mentor->certificate = url(Storage::url($mentor->certificate));
        $mentor->identity_card = url(Storage::url($mentor->identity_card));
        $mentor->cv = url(Storage::url($mentor->cv));
    }

    public function nonActiveMentors($request): array
    {
        $validator = $this->mentorValidator->validateMentorId($request);

        if ($validator) return $validator;

        DB::beginTransaction();
        try {
            $mentorId = $request->input('mentor_id');

            $mentor = $this->mentorRepo->getMentorCredentials($mentorId);

            if (!$mentor) return ResponseHelper::notFound('Mentor tidak ditemukan');

            $mentorAccount = $this->mentorRepo->updateMentorAccountStatus($mentorId, !$mentor->status);

            if (!$mentorAccount) return ResponseHelper::error('Gagal menonaktifkan mentor');

            DB::commit();

            $mentor = $this->mentorRepo->getMentorCredentials($mentorId);

            if ($mentor->status == 1) return ResponseHelper::success('Berhasil mengaktifkan mentor');
            else return ResponseHelper::success('Berhasil menonaktifkan mentor');

        } catch (\Exception $e) {
            DB::rollBack();
            return ResponseHelper::serverError($e->getMessage());
        }
    }

    public function getProfileDetails($request): array
    {
        try {
            $mentorId = $request->mentor->mentor_id;
            $mentor = $this->mentorRepo->getMentorById($mentorId);

            if (!$mentor) return ResponseHelper::notFound('Mentor tidak ditemukan');

            $this->getMentorFile($mentor);

            return ResponseHelper::success('Berhasil mengambil data mentor', $mentor);
        } catch (\Exception $e) {
            return ResponseHelper::serverError($e->getMessage());
        }
    }
}

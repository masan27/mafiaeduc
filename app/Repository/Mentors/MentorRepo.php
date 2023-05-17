<?php

namespace App\Repository\Mentors;

use App\Entities\MentorEntities;
use App\Models\Mentors\MentorCredentials;
use App\Traits\RepoTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class MentorRepo implements MentorRepoInterface
{
    use RepoTrait;

    private static function getDbTable(): object
    {
        return DB::table('mentors');
    }

    public static function getMentorByEmail($email)
    {
        return MentorCredentials::where('email', $email)->first();
    }

    public static function getMentorFullName($mentorId): string
    {
        return self::getDbTable()
            ->where('id', $mentorId)
            ->select('full_name')
            ->first()
            ->full_name;
    }

    public static function getCurrentRememberToken($mentorCredentialId): string
    {
        return self::getDbTable()
            ->where('id', $mentorCredentialId)
            ->first()
            ->remember_token;
    }

    public static function updatePassword($mentorCredentialId, $password): bool
    {
        return self::getDbTable()
            ->where('id', $mentorCredentialId)
            ->update([
                'password' => Hash::make($password),
                'updated_at' => now(),
            ]);
    }

    public static function updateRememberToken($mentorCredentialId, $token): bool
    {
        return self::getDbTable()
            ->where('id', $mentorCredentialId)
            ->update([
                'remember_token' => $token,
                'updated_at' => now(),
            ]);
    }

    public static function registerMentor(
        int    $user_id,
        int    $learning_method_id,
        int    $grade_id,
        string $full_name,
        string $photo,
        string $certificate,
        string $identity_card,
        string $cv,
        string $teaching_video,
        string $phone,
        int    $salary,
        string $linkedin
    ): int
    {
        return self::getDbTable()
            ->insertGetId([
                'user_id' => $user_id,
                'learning_method_id' => $learning_method_id,
                'grade_id' => $grade_id,
                'full_name' => $full_name,
                'photo' => $photo,
                'certificate' => $certificate,
                'identity_card' => $identity_card,
                'cv' => $cv,
                'teaching_video' => $teaching_video,
                'phone' => $phone,
                'salary' => $salary,
                'linkedin' => $linkedin,
                'created_at' => now(),
                'updated_at' => now()
            ]);
    }

    public static function insertMentorSubject($mentorId, $subjectIds): bool
    {
        return DB::table('mentor_subjects')
            ->insert([
                'mentor_id' => $mentorId,
                'subject_id' => $subjectIds,
                'created_at' => now(),
                'updated_at' => now()
            ]);
    }

    public static function checkMentorCanRegister(int $userId): bool
    {
        return !self::getDbTable()
            ->where('user_id', $userId)
            ->where('status', MentorEntities::MENTOR_STATUS_PENDING_APPROVAL)
            ->whereRaw('DATE_SUB(created_at, INTERVAL 7 DAY) < NOW()')
            ->exists();
    }

    public static function getMentorById(int $mentorId): object
    {
        return self::getDbTable()
            ->join('users', 'users.id', '=', 'mentors.user_id')
            ->where('mentors.id', $mentorId)
            ->select(
                'mentors.id',
                'users.email',
                'mentors.user_id',
                'mentors.learning_method_id',
                'mentors.grade_id',
                'mentors.full_name',
                'mentors.photo',
                'mentors.certificate',
                'mentors.identity_card',
                'mentors.cv',
                'mentors.status',
                'mentors.teaching_video',
                'mentors.phone',
                'mentors.salary',
                'mentors.linkedin',
            )->first();
    }

    public static function createMentorCredential($mentorId, $mentorEmail, $mentorPassword, $mentorApiToken): bool
    {
        return DB::table('mentor_credentials')
            ->insert([
                'mentor_id' => $mentorId,
                'email' => $mentorEmail,
                'password' => Hash::make($mentorPassword),
                'default_password' => $mentorPassword,
                'api_token' => $mentorApiToken,
                'created_at' => now(),
                'updated_at' => now()
            ]);
    }

    public static function updateMentorAccountStatus($mentorId, $status)
    {
        return DB::table('mentor_credentials')
            ->where('mentor_id', $mentorId)
            ->update([
                'status' => $status,
                'updated_at' => now()
            ]);
    }

    public static function acceptMentorApplication(int $mentorId): bool
    {
        return self::getDbTable()
            ->where('id', $mentorId)
            ->update([
                'status' => MentorEntities::MENTOR_STATUS_APPROVED,
                'updated_at' => now()
            ]);
    }

    public static function getAllMentors(): object
    {
        return self::getDbTable()
            ->where('status', MentorEntities::MENTOR_STATUS_APPROVED)
            ->select(
                'id',
                'user_id',
                'status',
                'learning_method_id',
                'grade_id',
                'full_name',
                'photo',
                'certificate',
                'identity_card',
                'cv',
                'teaching_video',
                'phone',
                'salary',
                'linkedin',
            )->get();
    }

    public static function getMentorTeachingDays(int $mentorId): object
    {
        return DB::table('mentor_teaching_days')
            ->join('days', 'mentor_teaching_days.day_id', '=', 'days.id')
            ->where('mentor_id', $mentorId)
            ->select(
                'mentor_teaching_days.day_id as id',
                'days.name'
            )
            ->get();
    }

    public static function getMentorSubjects(int $mentorId): object
    {
        return DB::table('mentor_subjects')
            ->join('subjects', 'mentor_subjects.subject_id', '=', 'subjects.id')
            ->where('mentor_id', $mentorId)
            ->select(
                'mentor_subjects.subject_id as id',
                'subjects.name'
            )
            ->get();
    }

    public static function getMentorCredentials(int $mentorId): object
    {
        return DB::table('mentor_credentials')
            ->where('mentor_id', $mentorId)
            ->select(
                'email',
                'status',
                'default_password',
            )
            ->first();
    }
}

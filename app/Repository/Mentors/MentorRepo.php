<?php

namespace App\Repository\Mentors;

use App\Entities\MentorEntities;
use App\Traits\RepoTrait;
use Illuminate\Support\Facades\DB;

class MentorRepo implements MentorRepoInterface
{
    use RepoTrait;

    private static function getDbTable()
    {
        return DB::table('mentors');
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

    public static function insertMentorTeachingDays($mentorId, $dayIds): bool
    {
        return DB::table('mentor_teaching_days')
            ->insert([
                'mentor_id' => $mentorId,
                'day_id' => $dayIds,
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
        return self::getDbTable()
            ->where('user_id', $userId)
            ->where('status', MentorEntities::MENTOR_STATUS_PENDING_APPROVAL)
            ->whereRaw('DATE_SUB(created_at, INTERVAL 7 DAY) > NOW()')
            ->exists();
    }

    public static function getMentorById(int $mentorId): object
    {
        return self::getDbTable()
            ->where('id', $mentorId)
            ->select(
                'mentors.id',
                'mentors.user_id',
                'mentors.learning_method_id',
                'mentors.grade_id',
                'mentors.full_name',
                'mentors.photo',
                'mentors.certificate',
                'mentors.identity_card',
                'mentors.cv',
                'mentors.teaching_video',
                'mentors.phone',
                'mentors.salary',
                'mentors.linkedin',
            )->first();
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
        return self::getAll([
            'mentors.id',
            'mentors.user_id',
            'mentors.learning_method_id',
            'mentors.grade_id',
            'mentors.full_name',
            'mentors.photo',
            'mentors.certificate',
            'mentors.identity_card',
            'mentors.cv',
            'mentors.teaching_video',
            'mentors.phone',
            'mentors.salary',
            'mentors.linkedin',
        ]);
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
}

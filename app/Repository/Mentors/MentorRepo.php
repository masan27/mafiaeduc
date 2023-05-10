<?php

namespace App\Repository\Mentors;

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
}

<?php

namespace App\Repository\Mentors;

interface MentorRepoInterface
{
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
    ): int;

    public static function insertMentorTeachingDays(int $mentorId, int $dayIds): bool;

    public static function insertMentorSubject(int $mentorId, int $subjectIds): bool;
}

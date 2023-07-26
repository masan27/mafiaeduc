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

    public static function checkMentorCanRegister(int $userId): bool;

    public static function insertMentorSubject(int $mentorId, int $subjectIds): bool;

    public static function getMentorById(int $mentorId): object;

    public static function acceptMentorApplication(int $mentorId): bool;

    public static function createMentorCredential(int $mentorId, string $mentorEmail, string $mentorPassword, string $mentorApiToken);

    public static function getAllMentors(): object;

    public static function getMentorSubjects(int $mentorId): object;

    public static function getMentorTeachingDays(int $mentorId): object;

    public static function getMentorCredentials(int $mentorId): object;

    public static function updateMentorAccountStatus(int $mentorId, int $status);

    public static function getMentorByEmail(string $email);

    public static function getMentorFullName(int $mentorId): string;

    public static function getCurrentRememberToken(int $mentorCredentialId): string;

    public static function updatePassword(int $mentorCredentialId, string $password): bool;

    public static function updateRememberToken(int $mentorCredentialId, string $token): bool;

    public static function updateMentorProfile(int $mentorId, string $fullName): bool;

    public static function getRecommendedMentors(): object;

    public static function getAllMentorClass(int $mentorId);
}

<?php

namespace App\Services\Mentors;

use Illuminate\Http\Request;

interface MentorServiceInterface
{
    public function registerMentor(Request $request): array;

    public function acceptMentorApplication(Request $request): array;

    public function getAllMentors(): array;

    public function getMentorDetails(int $mentorId): array;

    public function nonActiveMentors(Request $request): array;

    public function getProfileDetails(Request $request): array;

    public function updateMentorProfile(Request $request): array;

    public function getRecommendedMentors(): array;

    public function getAllMentorClass(int $mentorId): array;

    public function resetPassword(int $mentorId): array;

    public function changePassword(Request $request): array;

    public function changePhoto(Request $request): array;

    public function getMentorStats(Request $request): array;
}

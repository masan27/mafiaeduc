<?php

namespace App\Services\Mentors;

use Illuminate\Http\Request;

interface MentorServiceInterface
{
    public function registerMentor(Request $request): array;

    public function acceptMentorApplication(Request $request): array;

    public function getAllMentors(Request $request): array;

    public function getAllMentorRequest(Request $request): array;

    public function getMentorDetails(int $mentorId): array;

    public function getMentorRequestDetails(int $mentorId): array;

    public function nonActiveMentors(Request $request): array;

    public function getProfileDetails(Request $request): array;

    public function updateMentorProfile(Request $request): array;

    public function getRecommendedMentors(): array;

    public function getAllMentorClass(int $mentorId): array;

    public function resetPassword(Request $request): array;

    public function changePassword(Request $request): array;

    public function changePhoto(Request $request): array;

    public function getMentorStats(Request $request): array;
}

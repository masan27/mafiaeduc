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
}
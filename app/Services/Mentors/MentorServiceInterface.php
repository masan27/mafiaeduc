<?php

namespace App\Services\Mentors;

use Illuminate\Http\Request;

interface MentorServiceInterface
{
    public function registerMentor(Request $request): array;

    public function acceptMentorApplication(Request $request): array;

    public function getAllMentors(): array;

    public function getMentorDetails(int $mentorId): array;
}

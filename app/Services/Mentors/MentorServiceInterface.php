<?php

namespace App\Services\Mentors;

use Illuminate\Http\Request;

interface MentorServiceInterface
{
    public function registerMentor(Request $request): array;
}

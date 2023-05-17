<?php

namespace App\Http\Controllers\Mentors;

use App\Http\Controllers\Controller;
use App\Services\Mentors\MentorServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MentorController extends Controller
{
    protected MentorServiceInterface $mentorService;

    public function __construct(MentorServiceInterface $mentorService)
    {
        $this->mentorService = $mentorService;
    }

    public function mentorRegister(Request $request): JsonResponse
    {
        $data = $this->mentorService->registerMentor($request);
        return response()->json($data, $data['code']);
    }

    public function updateProfile(Request $request): JsonResponse
    {
        $data = $this->mentorService->updateMentorProfile($request);
        return response()->json($data, $data['code']);
    }
}

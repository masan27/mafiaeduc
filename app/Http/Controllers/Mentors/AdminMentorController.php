<?php

namespace App\Http\Controllers\Mentors;

use App\Http\Controllers\Controller;
use App\Services\Mentors\MentorServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AdminMentorController extends Controller
{
    protected MentorServiceInterface $mentorService;

    public function __construct(MentorServiceInterface $mentorService)
    {
        $this->mentorService = $mentorService;
    }

    public function acceptMentorApplication(Request $request): JsonResponse
    {
        $data = $this->mentorService->acceptMentorApplication($request);
        return response()->json($data, $data['code']);
    }

    public function getAllMentors(): JsonResponse
    {
        $data = $this->mentorService->getAllMentors();
        return response()->json($data, $data['code']);
    }

    public function getMentorDetails(int $mentorId): JsonResponse
    {
        $data = $this->mentorService->getMentorDetails($mentorId);
        return response()->json($data, $data['code']);
    }

    public function nonActiveMentors(Request $request): JsonResponse
    {
        $data = $this->mentorService->nonActiveMentors($request);
        return response()->json($data, $data['code']);
    }

    public function resetPassword(int $mentorId): JsonResponse
    {
        $data = $this->mentorService->resetPassword($mentorId);
        return response()->json($data, $data['code']);
    }
}

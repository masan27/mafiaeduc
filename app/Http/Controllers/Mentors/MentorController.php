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

    public function getRecommendedMentors(): JsonResponse
    {
        $data = $this->mentorService->getRecommendedMentors();
        return response()->json($data, $data['code']);
    }

    public function getAllMentorClass(int $mentorId): JsonResponse
    {
        $data = $this->mentorService->getAllMentorClass($mentorId);
        return response()->json($data, $data['code']);
    }

    public function changePassword(Request $request): JsonResponse
    {
        $data = $this->mentorService->changePassword($request);
        return response()->json($data, $data['code']);
    }

    public function changePhoto(Request $request): JsonResponse
    {
        $data = $this->mentorService->changePhoto($request);
        return response()->json($data, $data['code']);
    }

    public function getMentorStats(Request $request): JsonResponse
    {
        $data = $this->mentorService->getMentorStats($request);
        return response()->json($data, $data['code']);
    }
}

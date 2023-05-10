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
}

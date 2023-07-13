<?php

namespace App\Http\Controllers\Mentors;

use App\Http\Controllers\Controller;
use App\Services\Mentors\PrivateClasses\MentorPrivateClassServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MentorPrivateClassController extends Controller
{
    protected MentorPrivateClassServiceInterface $mentorPrivateClass;

    public function __construct(MentorPrivateClassServiceInterface $mentorPrivateClass)
    {
        $this->mentorPrivateClass = $mentorPrivateClass;
    }

    public function getMentorPrivateClasses(Request $request): JsonResponse
    {
        $data = $this->mentorPrivateClass->getMentorPrivateClasses($request);
        return response()->json($data, $data['code']);
    }

    public function addMentorPrivateClass(Request $request): JsonResponse
    {
        $data = $this->mentorPrivateClass->addMentorPrivateClass($request);
        return response()->json($data, $data['code']);
    }

    public function deleteMentorPrivateClass(int $privateClassId): JsonResponse
    {
        $data = $this->mentorPrivateClass->deleteMentorPrivateClass($privateClassId);
        return response()->json($data, $data['code']);
    }

    public function getMentorPrivateClassDetails(int $privateClassId): JsonResponse
    {
        $data = $this->mentorPrivateClass->getMentorPrivateClassDetails($privateClassId);
        return response()->json($data, $data['code']);
    }

    public function editMentorPrivateClass(int $privateClassId, Request $request): JsonResponse
    {
        $data = $this->mentorPrivateClass->editMentorPrivateClass($privateClassId, $request);
        return response()->json($data, $data['code']);
    }

    public function changeMentorPrivateClassStatus(int $privateClassId, Request $request): JsonResponse
    {
        $data = $this->mentorPrivateClass->changeMentorPrivateClassStatus($privateClassId, $request);
        return response()->json($data, $data['code']);
    }
}

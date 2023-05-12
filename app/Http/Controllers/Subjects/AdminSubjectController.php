<?php

namespace App\Http\Controllers\Subjects;

use App\Http\Controllers\Controller;
use App\Services\Subjects\SubjectServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AdminSubjectController extends Controller
{
    protected SubjectServiceInterface $subjectService;

    public function __construct(SubjectServiceInterface $subjectService)
    {
        $this->subjectService = $subjectService;
    }

    public function getAllSubjects(): JsonResponse
    {
        $data = $this->subjectService->getAllSubjects();
        return response()->json($data, $data['code']);
    }

    public function addSubject(Request $request): JsonResponse
    {
        $data = $this->subjectService->addNewSubject($request);
        return response()->json($data, $data['code']);
    }

    public function updateSubject(Request $request, int $subjectId): JsonResponse
    {
        $data = $this->subjectService->updateSubject($request, $subjectId);
        return response()->json($data, $data['code']);
    }

    public function deleteSubject(int $subjectId): JsonResponse
    {
        $data = $this->subjectService->deleteSubject($subjectId);
        return response()->json($data, $data['code']);
    }
}

<?php

namespace App\Http\Controllers\Subjects;

use App\Http\Controllers\Controller;
use App\Services\Subjects\SubjectServiceInterface;
use Illuminate\Http\JsonResponse;

class SubjectController extends Controller
{
    protected SubjectServiceInterface $subjectService;

    public function __construct(SubjectServiceInterface $subjectService)
    {
        $this->subjectService = $subjectService;
    }

    public function getActiveSubjects(): JsonResponse
    {
        $data = $this->subjectService->getActiveSubjects();
        return response()->json($data, $data['code']);
    }
}

<?php

namespace App\Http\Controllers\Grades;

use App\Http\Controllers\Controller;
use App\Services\Grades\GradeServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GradeController extends Controller
{
    protected GradeServiceInterface $gradeService;

    public function __construct(GradeServiceInterface $gradeService)
    {
        $this->gradeService = $gradeService;
    }

    public function getGrades(Request $request): JsonResponse
    {
        $data = $this->gradeService->getGrades($request);
        return response()->json($data, $data['code']);
    }
}

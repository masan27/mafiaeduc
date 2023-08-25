<?php

namespace App\Services\Grades;

use Illuminate\Http\Request;

interface GradeServiceInterface
{
    public function getGrades(Request $request): array;
}

<?php

namespace App\Http\Controllers\GroupClasses;

use App\Http\Controllers\Controller;
use App\Services\GroupClasses\GroupClassServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GroupClassController extends Controller
{
    protected GroupClassServiceInterface $groupClassService;

    public function __construct(GroupClassServiceInterface $groupClassService)
    {
        $this->groupClassService = $groupClassService;
    }

    public function getAllGroupClasses(Request $request): JsonResponse
    {
        $data = $this->groupClassService->getAllGroupClasses($request);
        return response()->json($data, $data['code']);
    }

    public function getGroupClassDetails(int $groupClassId, Request $request): JsonResponse
    {
        $data = $this->groupClassService->getGroupClassDetails($groupClassId, $request);
        return response()->json($data, $data['code']);
    }
}

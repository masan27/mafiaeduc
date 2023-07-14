<?php

namespace App\Http\Controllers\PrivateClasses;

use App\Http\Controllers\Controller;
use App\Services\PrivateClasses\PrivateClassServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PrivateClassController extends Controller
{
    protected PrivateClassServiceInterface $privateClassService;

    public function __construct(PrivateClassServiceInterface $privateClassService)
    {
        $this->privateClassService = $privateClassService;
    }

    public function getAllPrivateClasses(Request $request): JsonResponse
    {
        $data = $this->privateClassService->getAllPrivateClasses($request);
        return response()->json($data, $data['code']);
    }

    public function getPrivateClassDetails(int $privateClassId, Request $request): JsonResponse
    {
        $data = $this->privateClassService->getPrivateClassDetails($privateClassId, $request);
        return response()->json($data, $data['code']);
    }
}

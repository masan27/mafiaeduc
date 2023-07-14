<?php

namespace App\Http\Controllers\Materials;

use App\Http\Controllers\Controller;
use App\Services\Materials\MaterialServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    protected MaterialServiceInterface $materialService;

    public function __construct(MaterialServiceInterface $materialService)
    {
        $this->materialService = $materialService;
    }

    public function getActiveMaterial(Request $request): JsonResponse
    {
        $data = $this->materialService->getActiveMaterial($request);
        return response()->json($data, $data['code']);
    }

    public function getMaterialDetails(int $materialId): JsonResponse
    {
        $data = $this->materialService->getMaterialDetails($materialId);
        return response()->json($data, $data['code']);
    }

    public function getUserMaterial(): JsonResponse
    {
        $data = $this->materialService->getUserMaterial();
        return response()->json($data, $data['code']);
    }

}

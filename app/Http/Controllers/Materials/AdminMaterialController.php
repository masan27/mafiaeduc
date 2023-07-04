<?php

namespace App\Http\Controllers\Materials;

use App\Http\Controllers\Controller;
use App\Services\Admins\Materials\AdminMaterialServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AdminMaterialController extends Controller
{
    protected AdminMaterialServiceInterface $adminMaterialService;

    public function __construct(AdminMaterialServiceInterface $adminMaterialService)
    {
        $this->adminMaterialService = $adminMaterialService;
    }

    public function getAllMaterial(): JsonResponse
    {
        $data = $this->adminMaterialService->getAllMaterial();
        return response()->json($data, $data['code']);
    }

    public function addMaterial(Request $request): JsonResponse
    {
        $data = $this->adminMaterialService->addMaterial($request);
        return response()->json($data, $data['code']);
    }

    public function updateMaterial(int $materialId, Request $request): JsonResponse
    {
        $data = $this->adminMaterialService->updateMaterial($materialId, $request);
        return response()->json($data, $data['code']);
    }

    public function deleteMaterial(int $materialId): JsonResponse
    {
        $data = $this->adminMaterialService->deleteMaterial($materialId);
        return response()->json($data, $data['code']);
    }

    public function downloadMaterialPreview(int $materialId)
    {
        return $this->adminMaterialService->downloadMaterialPreview($materialId);
    }

    public function downloadMaterialSource(int $materialId)
    {
        return $this->adminMaterialService->downloadMaterialSource($materialId);
    }
}

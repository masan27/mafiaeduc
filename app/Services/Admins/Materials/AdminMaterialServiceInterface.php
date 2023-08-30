<?php

namespace App\Services\Admins\Materials;

use Illuminate\Http\Request;

interface AdminMaterialServiceInterface
{
    public function getAllMaterial(Request $request): array;

    public function getMaterialDetails(int $id): array;

    public function addMaterial(Request $request): array;

    public function updateMaterial(int $id, Request $request): array;

    public function deleteMaterial(int $id): array;

    public function assignUserMaterial(Request $request): array;

    public function downloadMaterialPreview(int $materialId);

    public function downloadMaterialSource(int $materialId);
}

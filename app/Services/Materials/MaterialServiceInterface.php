<?php

namespace App\Services\Materials;

use Illuminate\Http\Request;

interface MaterialServiceInterface
{
    public function getActiveMaterial(Request $request): array;

    public function getMaterialDetails(int $materialId): array;

    public function getUserMaterial(): array;
}

<?php

namespace App\Services\Materials;

use App\Helpers\FileHelper;
use App\Helpers\ResponseHelper;
use App\Models\Materials\Material;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MaterialService implements MaterialServiceInterface
{
    public function getActiveMaterial(Request $request): array
    {
        try {
            $search = $request->input('search');
            $gradeId = $request->input('grade');
            $sortPrice = $request->input('sort_price');

            $materials = Material::active()
                ->with('grade')
                ->when($gradeId, function ($query, $gradeId) {
                    return $query->where('grade_id', $gradeId);
                })
                ->when($sortPrice, function ($query, $sortPrice) {
                    return $query->orderBy('price', $sortPrice);
                })
                ->when($search, function ($query, $search) {
                    return $query->where('title', 'like', "%$search%")
                        ->orWhere('price', 'like', "%$search%")
                        ->orWhereHas('grade', function ($query) use ($search) {
                            $query->where('name', 'like', "%$search%");
                        })
                        ->orWhere('description', 'like', "%$search%");
                })
                ->get();

            if ($materials->isEmpty()) return ResponseHelper::notFound('Data materi tidak ditemukan');

            foreach ($materials as $material) {
                $material->cover_image = FileHelper::getFileUrl($material->cover_image);
                $material->author = 'Mafia Education';
            }

            return ResponseHelper::success('Berhasil mendapatkan materi', $materials);
        } catch (\Exception $e) {
            return ResponseHelper::serverError($e->getMessage());
        }
    }

    public function getMaterialDetails(int $materialId): array
    {
        try {
            $material = Material::active()
                ->with('grade')
                ->where('id', $materialId)
                ->first();

            if (!$material) return ResponseHelper::notFound('Data materi tidak ditemukan');

            // $material->cover_image = FileHelper::getFileUrl($material->cover_image);
            $material->author = 'Mafia Education';

            return ResponseHelper::success('Berhasil mendapatkan detail materi', $material);
        } catch (\Exception $e) {
            return ResponseHelper::serverError($e->getMessage());
        }
    }

    public function getUserMaterial(): array
    {
        try {
            $userId = Auth::id();

            $materials = Material::active()
                ->with('grade')
                ->whereHas('users', function ($query) use ($userId) {
                    $query->where('user_id', $userId);
                })
                ->get();

            if ($materials->isEmpty()) return ResponseHelper::notFound('Data materi tidak ditemukan');

            foreach ($materials as $material) {
                $material->cover_image = FileHelper::getFileUrl($material->cover_image);
                $material->author = 'Mafia Education';
            }

            return ResponseHelper::success('Berhasil mendapatkan data materi', $materials);
        } catch (\Exception $e) {
            return ResponseHelper::serverError($e->getMessage());
        }

    }
}

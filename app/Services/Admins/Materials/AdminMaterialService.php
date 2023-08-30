<?php

namespace App\Services\Admins\Materials;

use App\Helpers\FileHelper;
use App\Helpers\ResponseHelper;
use App\Models\Materials\Material;
use App\Models\Users\User;
use App\Validators\MaterialValidator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminMaterialService implements AdminMaterialServiceInterface
{
    protected MaterialValidator $materialValidator;

    public function __construct(MaterialValidator $materialValidator)
    {
        $this->materialValidator = $materialValidator;
    }

    public function getAllMaterial(Request $request): array
    {
        try {
            $search = $request->query('search');
            $count = $request->query('count');
            $materials = Material::with('grade')
                ->when($search, function ($query, $search) {
                    return $query->where('title', 'like', "%$search%")
                        ->orWhere('description', 'like', "%$search%")
                        ->orWhere('benefits', 'like', "%$search%")
                        ->orWhereHas('grade', function ($query) use ($search) {
                            return $query->where('name', 'like', "%$search%");
                        });
                })
                ->paginate($count);

            if ($materials->isEmpty()) {
                return ResponseHelper::notFound('Tidak ada material');
            }

            foreach ($materials as $material) {
                $material->cover_image = FileHelper::getFileUrl($material->cover_image);
                $material->preview_file = url('/v1/admin/material/download/' . $material->id . '/preview');
                $material->source_file = url('/v1/admin/material/download/' . $material->id . '/source');
            }

            return ResponseHelper::success('Berhasil mendapatkan data material', $materials);
        } catch (\Exception $e) {
            return ResponseHelper::serverError($e->getMessage());
        }

    }

    public function getMaterialDetails(int $id): array
    {
        try {
            $material = Material::with('grade')->find($id);

            if (!$material) {
                return ResponseHelper::notFound('Material tidak ditemukan');
            }
            
            $material->cover_image = FileHelper::getFileUrl($material->cover_image);
            $material->preview_file = url('/v1/admin/material/download/' . $material->id . '/preview');
            $material->source_file = url('/v1/admin/material/download/' . $material->id . '/source');

            return ResponseHelper::success('Berhasil mendapatkan detail material', $material);
        } catch (\Exception $e) {
            return ResponseHelper::serverError($e->getMessage());
        }

    }

    public function addMaterial($request): array
    {
        $validator = $this->materialValidator->validateAddMaterial($request);

        if ($validator) return $validator;

        DB::beginTransaction();
        try {
            $admin_id = $request->user()->id;
            $title = $request->input('title');
            $grade_id = $request->input('grade_id');
            $price = $request->input('price');
            $description = $request->input('description');
            $total_page = $request->input('total_page');
            $benefit = $request->input('benefit');

            $preview_file = $request->file('preview_file');
            $source_file = $request->file('source_file');
            $cover_image = $request->file('cover');

            $newMaterial = Material::create([
                'admin_id' => $admin_id,
                'title' => $title,
                'grade_id' => $grade_id,
                'price' => $price,
                'description' => $description,
                'total_page' => $total_page,
                'benefits' => $benefit,
                'cover_image' => ' ',
                'preview_file' => ' ',
                'source_file' => ' '
            ]);

            $materialFolder = 'materials/' . $newMaterial->id;

            if ($cover_image) {
                $cover_image = FileHelper::uploadFile($cover_image, $materialFolder, 'cover_image');
            }

            if ($preview_file) {
                $preview_file = FileHelper::uploadFile($preview_file, $materialFolder, 'preview_file');
            }

            if ($source_file) {
                $source_file = FileHelper::uploadFile($source_file, $materialFolder, 'source_file');
            }

            $newMaterial->cover_image = $cover_image;
            $newMaterial->preview_file = $preview_file;
            $newMaterial->source_file = $source_file;
            $newMaterial->save();

            DB::commit();
            return ResponseHelper::success('Material berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();
            return ResponseHelper::serverError($e->getMessage());
        }
    }

    public function deleteMaterial(int $id): array
    {
        DB::beginTransaction();
        try {
            $material = Material::find($id);

            if (!$material) {
                return ResponseHelper::notFound('Material tidak ditemukan');
            }

            $material->delete();

            DB::commit();
            return ResponseHelper::success('Berhasil menghapus material');
        } catch (\Exception $e) {
            DB::rollBack();
            return ResponseHelper::serverError($e->getMessage());
        }

    }

    public function updateMaterial(int $id, $request): array
    {
        $validator = $this->materialValidator->validateUpdateMaterial($request);

        if ($validator) return $validator;

        DB::beginTransaction();
        try {
            $title = $request->input('title');
            $grade_id = $request->input('grade_id');
            $price = $request->input('price');
            $description = $request->input('description');
            $total_page = $request->input('total_page');
            $benefit = $request->input('benefit');

            $preview_file = $request->file('preview_file');
            $source_file = $request->file('source_file');
            $cover_image = $request->file('cover');

            $material = Material::find($id);

            if (!$material) {
                return ResponseHelper::notFound('Material tidak ditemukan');
            }

            $materialFolder = 'materials/' . $material->id;

            if ($cover_image) {
                FileHelper::deleteFile($material->cover_image);
                $cover_image = FileHelper::uploadFile($cover_image, $materialFolder, 'cover_image');
            }

            if ($preview_file) {
                FileHelper::deleteFile($material->preview_file);
                $preview_file = FileHelper::uploadFile($preview_file, $materialFolder, 'preview_file');
            }

            if ($source_file) {
                FileHelper::deleteFile($material->source_file);
                $source_file = FileHelper::uploadFile($source_file, $materialFolder, 'source_file');
            }

            $material->title = $title ?? $material->title;
            $material->grade_id = $grade_id ?? $material->grade_id;
            $material->price = $price ?? $material->price;
            $material->description = $description ?? $material->description;
            $material->total_page = $total_page ?? $material->total_page;
            $material->benefits = $benefit ?? $material->benefits;
            $material->cover_image = $cover_image ?? $material->cover_image;
            $material->preview_file = $preview_file ?? $material->preview_file;
            $material->source_file = $source_file ?? $material->source_file;
            $material->save();

            DB::commit();
            return ResponseHelper::success('Berhasil merubah data material');
        } catch (\Exception $e) {
            DB::rollBack();
            return ResponseHelper::serverError($e->getMessage());
        }

    }

    public function assignUserMaterial(Request $request): array
    {
        $validator = $this->materialValidator->validateAssignUserMaterial($request);

        if ($validator) return $validator;

        DB::beginTransaction();
        try {
            $userId = $request->input('user_id');
            $materialId = $request->input('material_id');

            $user = User::find($userId);

            if (!$user) {
                return ResponseHelper::notFound('User tidak ditemukan');
            }

            $material = Material::find($materialId);

            if (!$material) {
                return ResponseHelper::notFound('Material tidak ditemukan');
            }

            $user->materials()->attach($materialId);

            DB::commit();
            return ResponseHelper::success('Berhasil menambahkan material ke user');
        } catch (\Exception $e) {
            DB::rollBack();
            return ResponseHelper::serverError($e->getMessage());
        }

    }

    public function downloadMaterialPreview($materialId):
    \Symfony\Component\HttpFoundation\StreamedResponse|bool|array
    {
        $validator = $this->materialValidator->validateDownloadMaterial($materialId);

        if ($validator) return $validator;

        try {
            $material = Material::find($materialId);

            if (!$material) {
                return ResponseHelper::notFound('Material tidak ditemukan');
            }

            $materialPath = $material->preview_file;
            $isFileExist = FileHelper::isFileExist($materialPath);

            if (!$isFileExist) {
                return ResponseHelper::notFound('File tidak ditemukan');
            }

            return FileHelper::getDownloadFileUrl($materialPath, $material->title . ' - Preview');
        } catch (\Exception $e) {
            return ResponseHelper::serverError($e->getMessage());
        }
    }

    public function downloadMaterialSource($materialId):
    \Symfony\Component\HttpFoundation\StreamedResponse|bool|array
    {
        $validator = $this->materialValidator->validateDownloadMaterial($materialId);

        if ($validator) return $validator;

        try {
            $material = Material::find($materialId);

            if (!$material) {
                return ResponseHelper::notFound('Material tidak ditemukan');
            }

            $materialPath = $material->source_file;
            $isFileExist = FileHelper::isFileExist($materialPath);

            if (!$isFileExist) {
                return ResponseHelper::notFound('File tidak ditemukan');
            }

            return FileHelper::getDownloadFileUrl($materialPath, $material->title . ' - Source');
        } catch (\Exception $e) {
            return ResponseHelper::serverError($e->getMessage());
        }
    }
}

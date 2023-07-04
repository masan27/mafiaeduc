<?php

namespace App\Validators;

use App\Helpers\ValidationHelper;
use Illuminate\Support\Facades\Validator;

class MaterialValidator
{
    private ValidationHelper $validationHelper;

    public function __construct(ValidationHelper $validationHelper)
    {
        $this->validationHelper = $validationHelper;
    }

    public function validateAddMaterial($request): bool|array
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'cover' => 'required|file|mimes:jpg,jpeg,png|max:2048',
            'grade_id' => 'required|integer',
            'price' => 'required|integer',
            'description' => 'required|string',
            'total_page' => 'required|integer|min:1',
            'benefit' => 'nullable|string',
            'preview_file' => 'required|file|mimes:pdf|max:2048',
            'source_file' => 'required|file|mimes:pdf|max:2048',
        ], ValidationHelper::VALIDATION_MESSAGES);

        return $this->validationHelper->getValidationResponse($validator);
    }

    public function validateUpdateMaterial($request): bool|array
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'cover' => 'required|file|mimes:jpg,jpeg,png|max:2048',
            'grade_id' => 'required|integer',
            'price' => 'required|integer',
            'description' => 'required|string',
            'total_page' => 'required|integer|min:1',
            'benefit' => 'nullable|string',
            'preview_file' => 'nullable|file|mimes:pdf|max:2048',
            'source_file' => 'nullable|file|mimes:pdf|max:2048',
        ], ValidationHelper::VALIDATION_MESSAGES);

        return $this->validationHelper->getValidationResponse($validator);
    }

    public function validateDownloadMaterial($request): bool|array
    {
        $validator = Validator::make([
            'material_id' => $request
        ], [
            'material_id' => 'required|integer',
        ], ValidationHelper::VALIDATION_MESSAGES);

        return $this->validationHelper->getValidationResponse($validator);
    }
}

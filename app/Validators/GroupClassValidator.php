<?php

namespace App\Validators;

use App\Helpers\ValidationHelper;
use Illuminate\Support\Facades\Validator;

class GroupClassValidator
{
    private ValidationHelper $validationHelper;

    public function __construct(ValidationHelper $validationHelper)
    {
        $this->validationHelper = $validationHelper;
    }

    public function validateCreateGroupClasses($request): bool|array
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'grade_id' => 'required|integer|exists:grades,id',
            'subject_id' => 'required|integer|exists:subjects,id',
            'learning_method_id' => 'required|integer|exists:learning_methods,id',
            'description' => 'nullable|string',
            'additional_info' => 'nullable|string',
            'price' => 'required|integer',
        ], ValidationHelper::VALIDATION_MESSAGES);

        return $this->validationHelper->getValidationResponse($validator);
    }

    public function validateUpdateGroupClasses($request): bool|array
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'grade_id' => 'required|integer|exists:grades,id',
            'subject_id' => 'required|integer|exists:subjects,id',
            'learning_method_id' => 'required|integer|exists:learning_methods,id',
            'description' => 'nullable|string',
            'additional_info' => 'nullable|string',
            'price' => 'required|integer',
            'status' => 'nullable|integer',
        ], ValidationHelper::VALIDATION_MESSAGES);

        return $this->validationHelper->getValidationResponse($validator);
    }

    public function validateChangeGroupClasses($request): bool|array
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|integer',
        ], ValidationHelper::VALIDATION_MESSAGES);

        return $this->validationHelper->getValidationResponse($validator);
    }
}

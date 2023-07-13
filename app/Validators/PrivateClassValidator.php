<?php

namespace App\Validators;

use App\Helpers\ValidationHelper;
use Illuminate\Support\Facades\Validator;

class PrivateClassValidator
{
    private ValidationHelper $validationHelper;

    public function __construct(ValidationHelper $validationHelper)
    {
        $this->validationHelper = $validationHelper;
    }

    public function validateCreateMentorPrivateClasses($request): bool|array
    {
        $validator = Validator::make($request->all(), [
            'subject_id' => 'required|integer|exists:subjects,id',
            'learning_method_id' => 'required|integer|exists:learning_methods,id',
            'grade_id' => 'required|integer|exists:grades,id',
            'description' => 'required|string',
            'address' => 'required|string',
            'price' => 'required|integer',
            'total_slot' => 'required|integer',
        ], ValidationHelper::VALIDATION_MESSAGES);

        return $this->validationHelper->getValidationResponse($validator);
    }

    public function validateEditMentorPrivateClasses($request): bool|array
    {
        $validator = Validator::make($request->all(), [
            'subject_id' => 'required|integer|exists:subjects,id',
            'learning_method_id' => 'required|integer|exists:learning_methods,id',
            'grade_id' => 'required|integer|exists:grades,id',
            'description' => 'required|string',
            'address' => 'required|string',
            'price' => 'required|integer',
            'total_slot' => 'required|integer',
            'status' => 'required|boolean',
        ], ValidationHelper::VALIDATION_MESSAGES);

        return $this->validationHelper->getValidationResponse($validator);
    }

    public function validateChangeMentorPrivateClassStatus($request): bool|array
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|boolean',
        ], ValidationHelper::VALIDATION_MESSAGES);

        return $this->validationHelper->getValidationResponse($validator);
    }
}

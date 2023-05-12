<?php

namespace App\Validators;

use App\Helpers\ValidationHelper;
use Illuminate\Support\Facades\Validator;

class SubjectValidator
{
    private ValidationHelper $validationHelper;

    public function __construct(ValidationHelper $validationHelper)
    {
        $this->validationHelper = $validationHelper;
    }

    public function validateAddSubjectInput($request): bool|array
    {
        $validator = Validator::make($request->all(), [
            'subject_name' => 'required|string|max:255|unique:subjects,name',
            'description' => 'nullable|string',
        ], ValidationHelper::VALIDATION_MESSAGES);

        return $this->validationHelper->getValidationResponse($validator);
    }

    public function validateSubjectInput($request): bool|array
    {
        $validator = Validator::make($request->all(), [
            'subject_name' => 'required|string|max:255|unique:subjects,name',
            'description' => 'nullable|string',
            'status' => 'required|integer|between:0,1',
        ], ValidationHelper::VALIDATION_MESSAGES);

        return $this->validationHelper->getValidationResponse($validator);
    }

}

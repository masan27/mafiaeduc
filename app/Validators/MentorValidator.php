<?php

namespace App\Validators;

use App\Helpers\ValidationHelper;
use Illuminate\Support\Facades\Validator;

class MentorValidator
{
    private ValidationHelper $validationHelper;

    public function __construct(ValidationHelper $validationHelper)
    {
        $this->validationHelper = $validationHelper;
    }

    public function validateRegisterMentorInput($request): bool|array
    {
        $validator = Validator::make($request->all(), [
            'learning_method_id' => 'required|integer|exists:learning_methods,id',
            'grade_id' => 'required|integer|exists:grades,id',
            'full_name' => 'required|string|min:3|max:255',
            'address' => 'required|string|min:3|max:255',
            'photo' => 'required|image|mimes:jpeg,png,jpg|max:1024',
            'certificate' => 'required|image|mimes:jpeg,png,jpg|max:1024',
            'identity_card' => 'required|image|mimes:jpeg,png,jpg|max:1024',
            'cv' => 'required|file|mimes:pdf|max:5120',
            'teaching_video' => 'required|string|min:3|max:255',
            'phone' => 'required|string|min:3|max:16',
            'salary' => 'required|numeric|min:0',
            'subjects' => 'required|array',
            'subjects.*' => 'required|integer|exists:subjects,id',
            'linkedin' => 'nullable|string|min:3|max:255',
        ], ValidationHelper::VALIDATION_MESSAGES);

        return $this->validationHelper->getValidationResponse($validator);
    }

    public function validateMentorId($request): bool|array
    {
        $validator = Validator::make($request->all(), [
            'mentor_id' => 'required|integer',
        ], ValidationHelper::VALIDATION_MESSAGES);

        return $this->validationHelper->getValidationResponse($validator);
    }

    public function validateMentorUpdateProfileInput($request): bool|array
    {
        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string|max:45',
            'email' => 'required|email|max:45|unique:mentor_credentials,email,' . $request->mentor->mentor_id,
            'phone' => 'required|string|max:16',
            'linkedin' => 'nullable|string',
        ], ValidationHelper::VALIDATION_MESSAGES);

        return $this->validationHelper->getValidationResponse($validator);
    }

    public function validateChangePhotoInput($request): bool|array
    {
        $validator = Validator::make($request->all(), [
            'picture' => 'required|image|mimes:jpeg,png,jpg|max:2024',
        ], ValidationHelper::VALIDATION_MESSAGES);

        return $this->validationHelper->getValidationResponse($validator);
    }

    public function validateChangePasswordInput($request): bool|array
    {
        $validator = Validator::make($request->all(), [
            'old_password' => 'required|string|min:6|max:30',
            'new_password' => 'required|string|min:6|max:30|different:old_password',
            'confirm_new_password' => 'required|string|min:6|max:30|same:new_password',
        ], ValidationHelper::VALIDATION_MESSAGES);

        return $this->validationHelper->getValidationResponse($validator);
    }

    public function validateAddMentorPaymentMethod($request): bool|array
    {
        $validator = Validator::make($request->all(), [
            'payment_method_id' => 'required|integer|exists:payment_methods,id',
            'account_number' => 'required|string|max:45',
            'account_name' => 'required|string|max:45',
            'bank_name' => 'required|string|max:45',
        ], ValidationHelper::VALIDATION_MESSAGES);

        return $this->validationHelper->getValidationResponse($validator);
    }
}

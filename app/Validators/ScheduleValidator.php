<?php

namespace App\Validators;

use App\Helpers\ValidationHelper;
use Illuminate\Support\Facades\Validator;

class ScheduleValidator
{
    private ValidationHelper $validationHelper;

    public function __construct(ValidationHelper $validationHelper)
    {
        $this->validationHelper = $validationHelper;
    }

    public function validateCreateMentorPrivateClassSchedules($request): bool|array
    {
        $validator = Validator::make($request->all(), [
            'meeting_link' => 'required|string',
            'meeting_platform' => 'required|string',
            'date' => 'required|date_format:Y-m-d|after_or_equal:today',
            'time' => 'required|date_format:H:i',
        ], ValidationHelper::VALIDATION_MESSAGES);

        return $this->validationHelper->getValidationResponse($validator);
    }

    public function validateEditMentorPrivateClassSchedules($request): bool|array
    {
        $validator = Validator::make($request->all(), [
            'meeting_link' => 'required|string',
            'meeting_platform' => 'required|string',
            'date' => 'required|date_format:Y-m-d|after_or_equal:today',
            'time' => 'required|date_format:H:i',
        ], ValidationHelper::VALIDATION_MESSAGES);

        return $this->validationHelper->getValidationResponse($validator);
    }
}

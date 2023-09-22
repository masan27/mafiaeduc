<?php

namespace App\Validators;

use App\Helpers\ValidationHelper;
use Illuminate\Support\Facades\Validator;

class ReviewValidator
{
    private ValidationHelper $validationHelper;

    public function __construct(ValidationHelper $validationHelper)
    {
        $this->validationHelper = $validationHelper;
    }

    public function validateAddTransactionReview($request): bool|array
    {
        $validator = Validator::make($request->all(), [
            'sales_id' => 'required|string',
            'rating' => 'required|integer|between:1,5',
            'comment' => 'required|string',
        ], ValidationHelper::VALIDATION_MESSAGES);

        return $this->validationHelper->getValidationResponse($validator);
    }
}

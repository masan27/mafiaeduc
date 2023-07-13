<?php

namespace App\Validators;

use App\Helpers\ValidationHelper;
use Illuminate\Support\Facades\Validator;

class CheckoutValidator
{
    private ValidationHelper $validationHelper;

    public function __construct(ValidationHelper $validationHelper)
    {
        $this->validationHelper = $validationHelper;
    }

    public function validateMakeCheckout($request): bool|array
    {
        $validator = Validator::make($request->all(), [
            'payment_method_id' => 'required|integer|exists:payment_methods,id',
            'product_id' => 'required|integer',
            'type' => 'required|integer|in:1,2,3',
        ], ValidationHelper::VALIDATION_MESSAGES);

        return $this->validationHelper->getValidationResponse($validator);
    }

    public function validatePaymentConfirmation($request): bool|array
    {
        $validator = Validator::make($request->all(), [
            'sales_id' => 'required|string',
            'payment_method_id' => 'required|integer|exists:payment_methods,id',
            'account_name' => 'required|string',
            'payment_date' => 'nullable|date_format:Y-m-d',
            'amount' => 'required|integer',
            'proof_of_payment' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ], ValidationHelper::VALIDATION_MESSAGES);

        return $this->validationHelper->getValidationResponse($validator);
    }

    public function validateCancelPayment($request): bool|array
    {
        $validator = Validator::make($request->all(), [
            'sales_id' => 'required|string',
        ], ValidationHelper::VALIDATION_MESSAGES);

        return $this->validationHelper->getValidationResponse($validator);
    }
}

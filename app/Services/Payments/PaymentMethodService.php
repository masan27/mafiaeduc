<?php

namespace App\Services\Payments;

use App\Helpers\ResponseHelper;
use App\Repository\Payments\PaymentMethodRepoInterface;

class PaymentMethodService implements PaymentMethodServiceInterface
{
    protected PaymentMethodRepoInterface $paymentMethodRepo;

    public function __construct(PaymentMethodRepoInterface $paymentMethodRepo)
    {
        $this->paymentMethodRepo = $paymentMethodRepo;
    }

    public function getPaymentMethods(): array
    {
        try {
            $paymentMethods = $this->paymentMethodRepo->getActivePaymentMethods();

            if ($paymentMethods->isEmpty()) {
                return ResponseHelper::notFound('Tidak ada metode pembayaran yang aktif');
            }

            return ResponseHelper::success('Berhasil mendapatkan metode pembayaran', $paymentMethods);
        } catch (\Exception $e) {
            return ResponseHelper::serverError($e->getMessage());
        }
    }
}

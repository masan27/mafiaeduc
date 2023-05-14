<?php

namespace App\Services\Payments;

use App\Helpers\ResponseHelper;
use App\Repository\Payments\PaymentMethodRepoInterface;
use App\Validators\PaymentMethodValidator;
use Illuminate\Support\Facades\DB;

class PaymentMethodService implements PaymentMethodServiceInterface
{
    protected PaymentMethodRepoInterface $paymentMethodRepo;

    protected PaymentMethodValidator $paymentMethodValidator;

    public function __construct(PaymentMethodRepoInterface $paymentMethodRepo, PaymentMethodValidator $paymentMethodValidator)
    {
        $this->paymentMethodRepo = $paymentMethodRepo;
        $this->paymentMethodValidator = $paymentMethodValidator;
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

    public function addPaymentMethod($request): array
    {
        $validator = $this->paymentMethodValidator->validateAddPaymentMethodInput($request);

        if ($validator) return $validator;

        DB::beginTransaction();
        try {
            $name = $request->input('name');
            $fee = $request->input('fee');
            $code = $request->input('code');
            $account_number = $request->input('account_number');
            $icon = $request->input('icon');
            $type = $request->input('type');
            $description = $request->input('description');

            $this->paymentMethodRepo->insertPaymentMethod($name, $fee, $code, $account_number, $icon, $type, $description);

            DB::commit();
            return ResponseHelper::success('Berhasil menambahkan metode pembayaran');
        } catch (\Exception $e) {
            DB::rollBack();
            return ResponseHelper::serverError($e->getMessage());
        }
    }

    public function nonActivePaymentMethod($request): array
    {
        DB::beginTransaction();
        try {
            $paymentMethodId = $request->input('payment_method_id');

            $paymentMethod = $this->paymentMethodRepo->getPaymentMethod($paymentMethodId);

            if (!$paymentMethod) return ResponseHelper::notFound('Metode pembayaran tidak ditemukan');

            $paymentMethodStatus = $this->paymentMethodRepo->updatePaymentMethodStatus($paymentMethodId,
                !$paymentMethod->status);

            if (!$paymentMethodStatus) return ResponseHelper::error('Gagal menonaktifkan metode pembayaran');

            DB::commit();

            $mentor = $this->paymentMethodRepo->getPaymentMethod($paymentMethodId);

            if ($mentor->status == 1) return ResponseHelper::success('Berhasil mengaktifkan metode pembayaran');
            else return ResponseHelper::success('Berhasil menonaktifkan metode pembayaran');

        } catch (\Exception $e) {
            return ResponseHelper::serverError($e->getMessage());
        }
    }
}

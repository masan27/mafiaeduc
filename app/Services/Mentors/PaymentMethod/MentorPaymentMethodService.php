<?php

namespace App\Services\Mentors\PaymentMethod;

use App\Helpers\ResponseHelper;
use App\Repository\MentorPaymentMethod\MentorPaymentMethodRepoInterface;
use App\Validators\MentorValidator;
use Illuminate\Support\Facades\DB;

class MentorPaymentMethodService implements MentorPaymentMethodServiceInterface
{
    protected MentorPaymentMethodRepoInterface $mentorPaymentMethodRepo;
    protected MentorValidator $mentorValidator;

    public function __construct(MentorPaymentMethodRepoInterface $mentorPaymentMethodRepo, MentorValidator $mentorValidator)
    {
        $this->mentorPaymentMethodRepo = $mentorPaymentMethodRepo;
        $this->mentorValidator = $mentorValidator;
    }

    public function getMentorPaymentMethod($request): array
    {
        try {
            $mentorId = $request->input('mentor_id');

            $data = $this->mentorPaymentMethodRepo->getAllMentorPaymentMethod($mentorId);

            if ($data->isEmpty()) return ResponseHelper::notFound('Tidak ada payment method yang aktif');

            return ResponseHelper::success('Berhasil mendapatkan payment method', $data);
        } catch (\Exception $e) {
            return ResponseHelper::serverError($e->getMessage());
        }
    }

    public function addMentorPaymentMethod($request): array
    {
        $validator = $this->mentorValidator->validateAddMentorPaymentMethod($request);

        if ($validator) return $validator;

        DB::beginTransaction();
        try {
            $mentorId = $request->input('mentor_id');
            $paymentMethodId = $request->input('payment_method_id');
            $accountNumber = $request->input('account_number');
            $accountName = $request->input('account_name');
            $bankName = $request->input('bank_name');

            $this->mentorPaymentMethodRepo->addMentorPaymentMethod($mentorId, $paymentMethodId, $accountNumber, $accountName, $bankName);

            DB::commit();

            return ResponseHelper::success('Berhasil menambahkan payment method');
        } catch (\Exception $e) {
            DB::rollBack();
            return ResponseHelper::serverError($e->getMessage());
        }
    }

    public function deleteMentorPaymentMethod($mentorPaymentMethodId, $request): array
    {
        DB::beginTransaction();
        try {
            $mentorId = $request->mentor->mentor_id;
            $isSuccess = $this->mentorPaymentMethodRepo->deleteMentorPaymentMethod($mentorId,
                $mentorPaymentMethodId);

            if (!$isSuccess) return ResponseHelper::notFound('Payment method tidak ditemukan');

            DB::commit();
            return ResponseHelper::success('Berhasil menghapus payment method');
        } catch (\Exception $e) {
            DB::rollBack();
            return ResponseHelper::serverError($e->getMessage());
        }
    }
}

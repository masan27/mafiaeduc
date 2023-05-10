<?php

namespace App\Services\ForgotPassword;

use App\Helpers\ResponseHelper;
use App\Mail\ForgotPasswordMail;
use App\Repository\Auth\AuthRepoInterface;
use App\Repository\Users\UserRepoInterface;
use App\Validators\AuthValidator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordService implements ForgotPasswordServiceInterface
{
    protected AuthValidator $authValidator;

    protected AuthRepoInterface $authRepo;

    protected UserRepoInterface $userRepo;

    public function __construct(AuthValidator $authValidator, AuthRepoInterface $authRepo, UserRepoInterface $userRepo)
    {
        $this->authValidator = $authValidator;
        $this->authRepo = $authRepo;
        $this->userRepo = $userRepo;
    }

    public function sendResetLinkEmail($request): array
    {
        $validator = $this->authValidator->validateForgotPasswordInput($request);

        if ($validator) return $validator;

        DB::beginTransaction();
        try {
            $email = $request->input('email');

            $user = $this->authRepo->getUserByEmail($email);

            if (!$user) return ResponseHelper::error('Email tidak terdaftar');

            $otp = $this->generateOTP($email);

            $userFullName = $this->userRepo->getUserFullName($user->id);

            Mail::to($email)->send(new ForgotPasswordMail($otp, $email, $userFullName));

            $this->authRepo->insertOrUpdateOTP($user->id, $otp);

            $data = [
                'otp' => $otp,
            ];

            DB::commit();
            return ResponseHelper::success('OTP berhasil dikirim ke email', $data);
        } catch (\Exception $e) {
            DB::rollBack();
            return ResponseHelper::serverError($e->getMessage());
        }
    }

    private function generateOTP(string $email): string
    {
        return (string)rand(1000, 9999);
    }

    public function resetPassword($request): array
    {
        $validator = $this->authValidator->validateResetPasswordInput($request);

        if ($validator) return $validator;

        DB::beginTransaction();
        try {
            $email = $request->input('email');
            $password = $request->input('password');
            $otp = $request->input('otp');

            $user = $this->authRepo->getUserByEmail($email);

            if (!$user) return ResponseHelper::error('Email tidak terdaftar');

            if (Hash::check($password, $user->password)) return ResponseHelper::error('Password tidak boleh sama dengan password sebelumnya');

            $rememberToken = $this->authRepo->getUserRememberToken($user->id);

            if ($rememberToken === $otp) return ResponseHelper::error('OTP tidak valid');

            $this->authRepo->updateUserPassword($user->id, $password);

            $this->authRepo->insertUserRememberToken($user->id, $otp);

            $this->authRepo->deleteUserOtp($user->id);

            DB::commit();
            return ResponseHelper::success('Password berhasil diubah');
        } catch (\Exception $e) {
            DB::rollBack();
            return ResponseHelper::serverError($e->getMessage());
        }

    }

    public function verifyOtp($request): array
    {
        $validator = $this->authValidator->validateVerifyOtpInput($request);

        if ($validator) return $validator;

        DB::beginTransaction();
        try {
            $email = $request->input('email');
            $otp = $request->input('otp');

            $user = $this->authRepo->getUserByEmail($email);

            if (!$user) return ResponseHelper::error('Email tidak terdaftar');

            $userOtp = $this->authRepo->getUserOtp($user->id, $otp);

            if (!$userOtp) return ResponseHelper::error('OTP tidak valid');

            $data = [
                'email' => $email,
                'otp' => $otp,
            ];

            DB::commit();

            return ResponseHelper::success('OTP berhasil diverifikasi', $data);
        } catch (\Exception $e) {
            DB::rollBack();
            return ResponseHelper::serverError($e->getMessage());
        }
    }
}

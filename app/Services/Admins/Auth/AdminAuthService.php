<?php

namespace App\Services\Admins\Auth;

use App\Entities\AccessLogEntities;
use App\Entities\AdminEntities;
use App\Helpers\ResponseHelper;
use App\Mail\ForgotPasswordTokenMail;
use App\Repository\AccessLogs\AccessLogRepoInterface;
use App\Repository\Admin\AdminRepoInterface;
use App\Repository\PasswordResetToken\PasswordResetTokenRepoInterface;
use App\Validators\AdminAuthValidator;
use App\Validators\AuthValidator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class AdminAuthService implements AdminAuthServiceInterface
{
    protected AdminRepoInterface $adminRepo;
    protected AdminAuthValidator $adminAuthValidator;
    protected AccessLogRepoInterface $accessLogRepo;
    protected AuthValidator $authValidator;
    protected PasswordResetTokenRepoInterface $passwordResetTokenRepo;

    public function __construct(
        AdminRepoInterface              $adminRepo,
        AdminAuthValidator              $adminAuthValidator,
        AccessLogRepoInterface          $accessLogRepo,
        AuthValidator                   $authValidator,
        PasswordResetTokenRepoInterface $passwordResetTokenRepo
    )
    {
        $this->adminRepo = $adminRepo;
        $this->adminAuthValidator = $adminAuthValidator;
        $this->accessLogRepo = $accessLogRepo;
        $this->authValidator = $authValidator;
        $this->passwordResetTokenRepo = $passwordResetTokenRepo;
    }

    public function getLoginToken($request): array
    {
        $validator = $this->adminAuthValidator->validateLoginInput($request);

        if ($validator) return $validator;

        DB::beginTransaction();
        try {
            $email = $request->input('email');
            $password = $request->input('password');

            $admin = $this->adminRepo->getAdminByEmail($email);

            if (!$admin) return ResponseHelper::error('Username atau password salah');

            if ($admin->status == AdminEntities::STATUS_INACTIVE) return ResponseHelper::error('Akun dinonaktifkan sementara');

            if (!Hash::check($password, $admin->password)) return ResponseHelper::error('Username atau password salah');

            $token = $admin->createToken('admin_token')->plainTextToken;

            $data = [
                'token' => $token,
                'admin' => $admin
            ];

            $clientIP = $request->ip();
            $this->accessLogRepo->createLoginLogs($admin->id, $clientIP, $token,
                AccessLogEntities::ADMIN_LOGIN_TYPE);

            DB::commit();
            return ResponseHelper::success('Berhasil login', $data);
        } catch (\Exception $e) {
            DB::rollBack();
            return ResponseHelper::serverError($e->getMessage());
        }
    }

    public function logout($request): array
    {
        DB::beginTransaction();
        try {
            $adminId = $request->user()->id;
            $token = $request->bearerToken();

            $request->user()->currentAccessToken()->delete();

            $this->accessLogRepo->updateLogoutLogs($adminId, $token, AccessLogEntities::ADMIN_LOGIN_TYPE);

            DB::commit();
            return ResponseHelper::success('Berhasil logout');
        } catch (\Exception $e) {
            DB::rollBack();
            return ResponseHelper::serverError($e->getMessage());
        }
    }

    public function addNewAdmin($request): array
    {
        $validator = $this->adminAuthValidator->validateAddNewAdminInput($request);

        if ($validator) return $validator;

        DB::beginTransaction();
        try {
            $fullName = $request->input('full_name');
            $email = $request->input('email');
            $password = $request->input('password');

            $admin = $this->adminRepo->getAdminByEmail($email);

            if ($admin) return ResponseHelper::error('Email sudah terdaftar');

            $this->adminRepo->addNewAdmin($fullName, $email, $password);

            DB::commit();

            return ResponseHelper::success('Berhasil menambahkan admin');
        } catch (\Exception $e) {
            DB::rollBack();
            return ResponseHelper::serverError($e->getMessage());
        }
    }

    public function getAdminProfileDetails($request): array
    {
        try {
            $admin = $request->user();

            return ResponseHelper::success('Berhasil mengambil data admin', $admin);
        } catch (\Exception $e) {
            return ResponseHelper::serverError($e->getMessage());
        }
    }

    public function sendResetLinkEmail($request): array
    {
        $validator = $this->authValidator->validateForgotPasswordInput($request);

        if ($validator) return $validator;

        DB::beginTransaction();
        try {
            $email = $request->input('email');

            $admin = $this->adminRepo->getAdminByEmail($email);

            if (!$admin) return ResponseHelper::error('Email tidak terdaftar');

            $token = self::createNewResetPasswordToken();
            $this->passwordResetTokenRepo->insertOrUpdateToken($email, $token);

            $adminFullName = $admin->full_name;
            Mail::to($email)->send(new ForgotPasswordTokenMail($token, $email, $adminFullName));

            $data = [
                'email' => $email,
                'token' => $token
            ];

            DB::commit();
            return ResponseHelper::success('Berhasil mengirim email reset password', $data);
        } catch (\Exception $e) {
            DB::rollBack();
            return ResponseHelper::serverError($e->getMessage());
        }
    }

    private function createNewResetPasswordToken(): string
    {
        $token = Str::random(60);
        return hash('sha256', $token);
    }

    public function resetPassword($request): array
    {
        $validator = $this->authValidator->validateResetPasswordTokenInput($request);

        if ($validator) return $validator;

        DB::beginTransaction();
        try {
            $email = $request->input('email');
            $token = $request->input('token');
            $password = $request->input('password');

            $admin = $this->adminRepo->getAdminByEmail($email);

            if (!$admin) return ResponseHelper::error('Email tidak terdaftar', null, ResponseAlias::HTTP_UNAUTHORIZED);

            $tokenStatus = $this->passwordResetTokenRepo->checkTokenValid($email, $token);

            if (!$tokenStatus) return ResponseHelper::error('Token tidak valid', null, ResponseAlias::HTTP_UNAUTHORIZED);

            $adminId = $admin->id;
            $rememberToken = $this->adminRepo->getCurrentRememberToken($adminId);

            if ($rememberToken && $rememberToken === $token) {
                return ResponseHelper::error('Token tidak valid', null, ResponseAlias::HTTP_UNAUTHORIZED);
            }

            $this->adminRepo->updatePassword($adminId, $password);

            $this->adminRepo->updateRememberToken($adminId, $token);

            $this->passwordResetTokenRepo->deleteToken($email, $token);

            DB::commit();

            return ResponseHelper::success('Berhasil reset password');
        } catch (\Exception $e) {
            DB::rollBack();
            return ResponseHelper::serverError($e->getMessage());
        }
    }
}

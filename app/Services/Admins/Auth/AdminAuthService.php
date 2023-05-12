<?php

namespace App\Services\Admins\Auth;

use App\Entities\AccessLogEntities;
use App\Entities\AdminEntities;
use App\Helpers\ResponseHelper;
use App\Repository\AccessLogs\AccessLogRepoInterface;
use App\Repository\Admin\AdminRepoInterface;
use App\Validators\AdminAuthValidator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminAuthService implements AdminAuthServiceInterface
{
    protected AdminRepoInterface $adminRepo;

    protected AdminAuthValidator $adminAuthValidator;

    protected AccessLogRepoInterface $accessLogRepo;

    public function __construct(AdminRepoInterface $adminRepo, AdminAuthValidator $adminAuthValidator, AccessLogRepoInterface $accessLogRepo)
    {
        $this->adminRepo = $adminRepo;
        $this->adminAuthValidator = $adminAuthValidator;
        $this->accessLogRepo = $accessLogRepo;
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
}

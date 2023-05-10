<?php

namespace App\Services\Users;

use App\Helpers\ResponseHelper;
use App\Repository\Users\UserRepoInterface;
use App\Validators\UserValidator;
use Illuminate\Support\Facades\DB;

class UserService implements UserServiceInterface
{

    protected UserRepoInterface $userRepo;

    protected UserValidator $userValidator;

    public function __construct(UserRepoInterface $userRepo, UserValidator $userValidator)
    {
        $this->userRepo = $userRepo;
        $this->userValidator = $userValidator;
    }

    public function getUserDetails($request): array
    {
        try {
            $userId = $request->user()->id;

            $data = $this->userRepo->getUserDetailByUserId($userId);

            if (!$data) return ResponseHelper::notFound('User tidak ditemukan');

            return ResponseHelper::success('Berhasil mendapatkan data user', $data);
        } catch (\Exception $e) {
            return ResponseHelper::serverError($e->getMessage());
        }
    }

    public function updateUserDetails($request): array
    {
        $validator = $this->userValidator->validateUpdateUserDetailsInput($request);

        if ($validator) return $validator;

        DB::beginTransaction();
        try {
            $userId = $request->user()->id;

            $updateData = [
                'full_name' => $request->only('full_name'),
                'gender' => $request->only('gender'),
                'birth_date' => $request->only('birth_date'),
                'school_origin' => $request->only('school_origin'),
                'grade_id' => $request->only('grade_id'),
                'address' => $request->only('address'),
                'phone' => $request->only('phone'),
                'updated_at' => now(),
            ];

            $data = $this->userRepo->updateUserDetails($userId, $updateData);

            if (!$data) {
                DB::rollBack();
                return ResponseHelper::notFound('User tidak ditemukan');
            }

            DB::commit();
            return ResponseHelper::success('Berhasil mengubah data user', $data);
        } catch (\Exception $e) {
            DB::rollBack();
            return ResponseHelper::serverError($e->getMessage());
        }
    }

    public function changePassword($request): array
    {
        $validator = $this->userValidator->validateChangePasswordInput($request);

        if ($validator) return $validator;

        DB::beginTransaction();
        try {
            $userId = $request->user()->id;
            $newPassword = $request->input('new_password');

            $data = $this->userRepo->changeUserPassword($userId, $newPassword);

            if (!$data) {
                DB::rollBack();
                return ResponseHelper::notFound('User tidak ditemukan');
            }

            DB::commit();
            return ResponseHelper::success('Berhasil mengubah password', $data);
        } catch (\Exception $e) {
            DB::rollBack();
            return ResponseHelper::serverError($e->getMessage());
        }
    }
}

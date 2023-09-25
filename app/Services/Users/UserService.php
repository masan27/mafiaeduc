<?php

namespace App\Services\Users;

use App\Helpers\ResponseHelper;
use App\Repository\Users\UserRepoInterface;
use App\Validators\UserValidator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

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

            $updateData = [];

            if ($request->full_name){ $updateData['full_name'] = $request->full_name; }
            if ($request->gender){ $updateData['gender'] = $request->gender; }
            if ($request->birth_date){ $updateData['birth_date'] = $request->birth_date; }
            if ($request->school_origin){ $updateData['school_origin'] = $request->school_origin; }
            if ($request->grade_id){ $updateData['grade_id'] = $request->grade_id; }
            if ($request->address){ $updateData['address'] = $request->address; }
            if ($request->phone){ $updateData['phone'] = $request->phone; }
            if ($updateData){ $updateData['updated_at'] = now(); }

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

            $user = $this->userRepo->getUserById($userId);

            if (!$user) {
                return ResponseHelper::notFound('User tidak ditemukan');
            }

            if (Hash::check($newPassword, $user->password)) {
                return ResponseHelper::error(
                    'Password baru tidak boleh sama dengan password lama',
                    null,
                    ResponseAlias::HTTP_UNPROCESSABLE_ENTITY
                );
            }

            $data = $this->userRepo->changeUserPassword($userId, $newPassword);

            if (!$data) {
                DB::rollBack();
                return ResponseHelper::notFound('Gagal merubah password');
            }

            DB::commit();
            return ResponseHelper::success('Berhasil mengubah password', $data);
        } catch (\Exception $e) {
            DB::rollBack();
            return ResponseHelper::serverError($e->getMessage());
        }
    }
}

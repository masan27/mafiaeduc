<?php

namespace App\Services\Admins\Users;

use App\Helpers\ResponseHelper;
use App\Models\Users\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminUserService implements AdminUserServiceInterface
{
    public function getAllUsers(): array
    {
        try {
            $users = User::with('detail.grade')->get();

            if ($users->isEmpty()) {
                return ResponseHelper::notFound('Tidak ada user');
            }

            return ResponseHelper::success('Berhasil mendapatkan data user', $users);
        } catch (\Exception $e) {
            return ResponseHelper::serverError($e->getMessage());
        }

    }

    public function getUserDetails(int $id): array
    {
        try {
            $user = User::with('detail.grade')->find($id);

            if (!$user) {
                return ResponseHelper::notFound('User tidak ditemukan');
            }

            return ResponseHelper::success('Berhasil mendapatkan detail user', $user);
        } catch (\Exception $e) {
            return ResponseHelper::serverError($e->getMessage());
        }

    }

    public function resetPassword(int $id): array
    {
        DB::beginTransaction();
        try {
            $user = User::find($id);

            if (!$user) {
                return ResponseHelper::notFound('User tidak ditemukan');
            }

            $defaultPassword = '12345678';
            $user->password = Hash::make($defaultPassword);
            $user->save();

            $data = [
                'email' => $user->email,
                'password' => $defaultPassword
            ];

            DB::commit();
            return ResponseHelper::success('Berhasil mengubah password user', $data);
        } catch (\Exception $e) {
            DB::rollBack();
            return ResponseHelper::serverError($e->getMessage());
        }

    }

    public function nonActiveUsers(int $id): array
    {
        DB::beginTransaction();
        try {
            $user = User::find($id);

            if (!$user) {
                return ResponseHelper::notFound('User tidak ditemukan');
            }

            $user->status = !$user->status;
            $user->save();
            $user->refresh();

            $message = $user->status ? 'Berhasil mengaktifkan user' : 'Berhasil menonaktifkan user';

            DB::commit();
            return ResponseHelper::success($message);
        } catch (\Exception $e) {
            return ResponseHelper::serverError($e->getMessage());
        }

    }
}

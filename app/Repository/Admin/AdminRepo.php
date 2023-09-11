<?php

namespace App\Repository\Admin;

use App\Models\Admins\Admin;
use App\Traits\RepoTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminRepo implements AdminRepoInterface
{
    use  RepoTrait;

    private static function getDbTable(): object
    {
        return DB::table('admins');
    }

    public static function getAdminByEmail($email)
    {
        return Admin::where('email', $email)->first();
    }

    public static function getCurrentRememberToken($adminId): string
    {
        return self::getDbTable()
            ->where('id', $adminId)
            ->first()
            ->remember_token;
    }

    public static function updatePassword($adminId, $password): bool
    {
        return self::getDbTable()
            ->where('id', $adminId)
            ->update([
                'password' => Hash::make($password),
                'updated_at' => now(),
            ]);
    }

    public static function updateRememberToken($adminId, $token): bool
    {
        return self::getDbTable()
            ->where('id', $adminId)
            ->update([
                'remember_token' => $token,
                'updated_at' => now(),
            ]);
    }

    public static function addNewAdmin($fullName, $email, $password): bool
    {
        return self::getDbTable()->insert([
            'name' => $fullName,
            'email' => $email,
            'password' => Hash::make($password),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}

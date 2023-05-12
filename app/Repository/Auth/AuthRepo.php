<?php

namespace App\Repository\Auth;

use App\Models\Users\User;
use App\Traits\RepoTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthRepo implements AuthRepoInterface
{
    use RepoTrait;

    public static function registerUser($fullName, $email, $password, $role)
    {
        $userId = self::getDbTable()->insertGetId([
            'email' => $email,
            'role' => $role,
            'password' => Hash::make($password),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        self::registerUserDetail($userId, $fullName);

        return $userId;
    }

    private static function getDbTable()
    {
        return DB::table('users');
    }

    private static function registerUserDetail(int $userId, string $fullName): bool
    {
        return DB::table('user_details')->insert([
            'user_id' => $userId,
            'full_name' => $fullName,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }

    public static function getUserByEmail($email)
    {
        return User::active()
            ->where('email', $email)->first();
    }

    public static function insertOrUpdateOTP($userId, $otp)
    {
        return DB::table('password_resets')
            ->updateOrInsert(
                ['user_id' => $userId],
                [
                    'otp' => $otp,
                    'expired_at' => date('Y-m-d H:i:s', strtotime('+1 minutes')),
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ]
            );
    }

    public static function insertUserRememberToken($userId, $otp)
    {
        return self::getDbTable()
            ->where('id', $userId)
            ->update([
                'remember_token' => $otp,
                'updated_at' => date('Y-m-d H:i:s')
            ]);
    }

    public static function getUserRememberToken($userId)
    {
        return self::getDbTable()
            ->where('id', $userId)
            ->select('remember_token')
            ->first()
            ->remember_token;
    }

    public static function getUserOtp($userId, $otp)
    {
        return DB::table('password_resets')
            ->where('user_id', $userId)
            ->where('otp', $otp)
            ->where('expired_at', '>', date('Y-m-d H:i:s'))
            ->select('otp', 'expired_at')
            ->first();
    }

    public static function deleteUserOtp($userId)
    {
        return DB::table('password_resets')
            ->where('user_id', $userId)
            ->delete();
    }

    public static function updateUserPassword($userId, $password)
    {
        return self::getDbTable()
            ->where('id', $userId)
            ->update([
                'password' => Hash::make($password),
                'updated_at' => date('Y-m-d H:i:s')
            ]);
    }
}

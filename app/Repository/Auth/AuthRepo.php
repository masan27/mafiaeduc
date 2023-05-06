<?php

namespace App\Repository\Auth;

use App\Entities\UserEntities;
use App\Models\Users\User;
use App\Traits\RepoTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthRepo implements AuthRepoInterface
{
    use RepoTrait;

    public static function registerUser($fullName, $email, $password, $role): void
    {
        $userId = self::getDbTable()->insertGetId([
            'email' => $email,
            'role' => $role,
            'password' => Hash::make($password),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        self::registerUserDetail($userId, $fullName);
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
            ->where('status', UserEntities::USER_ACTIVE)
            ->where('email', $email)->first();
    }
}

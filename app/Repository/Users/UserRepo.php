<?php

namespace App\Repository\Users;

use App\Entities\UserEntities;
use App\Traits\RepoTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserRepo implements UserRepoInterface
{
    use RepoTrait;

    public static function getUserDetailByUserId(int $userId): object
    {
        return self::getDbTable()
            ->join('user_details', 'users.id', '=', 'user_details.user_id')
            ->where('users.id', $userId)
            ->where('users.status', UserEntities::USER_ACTIVE)
            ->select(
                'users.id',
                'users.email',
                'users.role',
                'user_details.full_name',
                'user_details.phone',
                'user_details.address',
                'user_details.school_origin',
                'user_details.birth_date',
                'user_details.gender',
                'users.created_at as registered_at',
            )
            ->first();
    }

    private static function getDbTable(): object
    {
        return DB::table('users');
    }

    public static function getUserFullName($userId): string
    {
        return DB::table('user_details')
            ->where('user_id', $userId)
            ->select('full_name')
            ->first()
            ->full_name;
    }

    public static function getUserById($userId): object
    {
        return self::getDbTable()
            ->where('id', $userId)
            ->where('status', UserEntities::USER_ACTIVE)
            ->first();
    }

    public static function changeUserPassword($userId, $newPassword): bool
    {
        return self::getDbTable()
            ->where('id', $userId)
            ->update([
                'password' => Hash::make($newPassword),
                'updated_at' => now()
            ]);
    }

    public static function updateUserDetails($userId, $data): bool
    {
        return DB::table('user_details')
            ->where('user_id', $userId)
            ->update($data);
    }
}

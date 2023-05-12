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

    public static function addNewAdmin($fullName, $email, $password): bool
    {
        return self::getDbTable()->insert([
            'full_name' => $fullName,
            'email' => $email,
            'password' => Hash::make($password),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}

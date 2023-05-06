<?php

namespace App\Repository\Users;

interface UserRepoInterface
{
    public static function getUserDetailByUserId(int $userId): object;
}

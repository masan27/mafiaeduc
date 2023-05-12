<?php

namespace App\Repository\Admin;

interface AdminRepoInterface
{
    public static function getAdminByEmail(string $email);

    public static function addNewAdmin(string $fullName, string $email, string $password): bool;
}

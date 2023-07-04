<?php

namespace App\Services\Admins\Users;

interface AdminUserServiceInterface
{
    public function getAllUsers(): array;

    public function getUserDetails(int $id): array;

    public function resetPassword(int $id): array;

    public function nonActiveUsers(int $id): array;
}

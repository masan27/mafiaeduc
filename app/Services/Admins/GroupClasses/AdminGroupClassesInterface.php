<?php

namespace App\Services\Admins\GroupClasses;

use Illuminate\Http\Request;

interface AdminGroupClassesInterface
{
    public function getAllGroupClasses(Request $request): array;

    public function deleteGroupClass(int $groupClassId): array;

    public function getGroupClassDetails(int $groupClassId): array;

    public function updateStatusGroupClass(int $groupClassId, Request $request): array;

    public function updateGroupClass(int $groupClassId, Request $request): array;

    public function addGroupClass(Request $request): array;
}

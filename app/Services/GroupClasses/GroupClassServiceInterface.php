<?php

namespace App\Services\GroupClasses;

use Illuminate\Http\Request;

interface GroupClassServiceInterface
{
    public function getAllGroupClasses(Request $request): array;

    public function getGroupClassDetails(int $groupClassId, Request $request): array;
}

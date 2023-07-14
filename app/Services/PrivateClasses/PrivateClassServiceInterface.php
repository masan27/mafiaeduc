<?php

namespace App\Services\PrivateClasses;

use Illuminate\Http\Request;

interface PrivateClassServiceInterface
{
    public function getAllPrivateClasses(Request $request): array;

    public function getPrivateClassDetails(int $privateClassId, Request $request): array;
}

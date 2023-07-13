<?php

namespace App\Http\Controllers\GroupClasses;

use App\Http\Controllers\Controller;
use App\Services\Admins\GroupClasses\AdminGroupClassesInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AdminGroupClassController extends Controller
{
    protected AdminGroupClassesInterface $adminGroupClasses;

    public function __construct(AdminGroupClassesInterface $adminGroupClasses)
    {
        $this->adminGroupClasses = $adminGroupClasses;
    }

    public function getAllGroupClasses(): JsonResponse
    {
        $data = $this->adminGroupClasses->getAllGroupClasses();
        return response()->json($data, $data['code']);
    }

    public function deleteGroupClass(int $groupClassId): JsonResponse
    {
        $data = $this->adminGroupClasses->deleteGroupClass($groupClassId);
        return response()->json($data, $data['code']);
    }


    public function getGroupClassDetails(int $groupClassId): JsonResponse
    {
        $data = $this->adminGroupClasses->getGroupClassDetails($groupClassId);
        return response()->json($data, $data['code']);
    }

    public function updateStatusGroupClass(int $groupClassId, Request $request): JsonResponse
    {
        $data = $this->adminGroupClasses->updateStatusGroupClass($groupClassId, $request);
        return response()->json($data, $data['code']);
    }

    public function updateGroupClass(int $groupClassId, Request $request): JsonResponse
    {
        $data = $this->adminGroupClasses->updateGroupClass($groupClassId, $request);
        return response()->json($data, $data['code']);
    }

    public function addGroupClass(Request $request): JsonResponse
    {
        $data = $this->adminGroupClasses->addGroupClass($request);
        return response()->json($data, $data['code']);
    }
}

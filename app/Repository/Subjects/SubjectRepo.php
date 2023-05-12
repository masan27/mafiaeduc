<?php

namespace App\Repository\Subjects;

use App\Traits\RepoTrait;
use Illuminate\Support\Facades\DB;

class SubjectRepo implements SubjectRepoInterface
{
    use RepoTrait;

    private static function getDbTable(): object
    {
        return DB::table('subjects');
    }

    public static function getAllSubjects(): object
    {
        return self::getAll([
            'id',
            'name',
            'description',
            'status',
        ]);
    }

    public static function insertSubject($name, $description): bool
    {
        return self::insert([
            'name' => $name,
            'description' => $description,
        ]);
    }

    public static function getSubjectById($subjectId)
    {
        return self::getDbTable()
            ->where('id', $subjectId)
            ->select(
                'id',
                'name',
                'description',
                'status',
            )->first();
    }

    public static function deleteSubject($subjectId): bool
    {
        return self::getDbTable()
            ->where('id', $subjectId)
            ->delete();
    }

    public static function updateSubject($subjectId, $name, $description, $status): bool
    {
        return self::getDbTable()
            ->where('id', $subjectId)
            ->update([
                'name' => $name,
                'description' => $description,
                'status' => $status,
            ]);
    }
}

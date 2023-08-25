<?php

namespace App\Repository\Subjects;

interface SubjectRepoInterface
{
    public static function getAllSubjects(string|null $search): object;

    public static function insertSubject(string $name, string $description): bool;

    public static function getSubjectById(int $subjectId);

    public static function updateSubject(int $subjectId, string $name, string $description, int $status):
    bool;

    public static function deleteSubject(int $subjectId): bool;

    public static function getActiveSubjects(): object;
}

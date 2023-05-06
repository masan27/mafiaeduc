<?php

namespace Database\Seeders\Subjects;

use App\Entities\SubjectEntities;
use App\Models\Subjects\Subject;
use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (Subject::count() > 1) {
            return;
        }

        $defaultSubject = [
            [
                'name' => 'Matematika',
                'description' => 'Pelajaran Matematika',
                'status' => SubjectEntities::SUBJECT_STATUS_ACTIVE,
            ],
            [
                'name' => 'Fisika',
                'description' => 'Pelajaran Fisika',
                'status' => SubjectEntities::SUBJECT_STATUS_ACTIVE,
            ],
            [
                'name' => 'Kimia',
                'description' => 'Pelajaran Kimia',
                'status' => SubjectEntities::SUBJECT_STATUS_ACTIVE,
            ],
            [
                'name' => 'Biologi',
                'description' => 'Pelajaran Biologi',
                'status' => SubjectEntities::SUBJECT_STATUS_ACTIVE,
            ],
            [
                'name' => 'Bahasa Indonesia',
                'description' => 'Pelajaran Bahasa Indonesia',
                'status' => SubjectEntities::SUBJECT_STATUS_ACTIVE,
            ],
            [
                'name' => 'Bahasa Inggris',
                'description' => 'Pelajaran Bahasa Inggris',
                'status' => SubjectEntities::SUBJECT_STATUS_ACTIVE,
            ],
            [
                'name' => 'Bahasa Mandarin',
                'description' => 'Pelajaran Bahasa Mandarin',
                'status' => SubjectEntities::SUBJECT_STATUS_ACTIVE,
            ],
            [
                'name' => 'IPA',
                'description' => 'Pelajaran Ilmu Pengetahuan Alam',
                'status' => SubjectEntities::SUBJECT_STATUS_ACTIVE,
            ],
            [
                'name' => 'IPS',
                'description' => 'Pelajaran Ilmu Pengetahuan Sosial',
                'status' => SubjectEntities::SUBJECT_STATUS_ACTIVE,
            ],
            [
                'name' => 'Akuntansi',
                'description' => 'Pelajaran Akuntansi',
                'status' => SubjectEntities::SUBJECT_STATUS_ACTIVE,
            ],
            [
                'name' => 'Ekonomi',
                'description' => 'Pelajaran Ekonomi',
                'status' => SubjectEntities::SUBJECT_STATUS_ACTIVE,
            ],
            [
                'name' => 'Geografi',
                'description' => 'Pelajaran Geografi',
                'status' => SubjectEntities::SUBJECT_STATUS_ACTIVE,
            ],
            [
                'name' => 'Sosiologi',
                'description' => 'Pelajaran Sosiologi',
                'status' => SubjectEntities::SUBJECT_STATUS_ACTIVE,
            ],
            [
                'name' => 'TPS PU',
                'description' => 'Pelajaran TPS PU',
                'status' => SubjectEntities::SUBJECT_STATUS_ACTIVE,
            ],
            [
                'name' => 'TPS PPU',
                'description' => 'Pelajaran TPS PPU',
                'status' => SubjectEntities::SUBJECT_STATUS_ACTIVE,
            ],
            [
                'name' => 'TPS PBM',
                'description' => 'Pelajaran TPS PBM',
                'status' => SubjectEntities::SUBJECT_STATUS_ACTIVE,
            ],
            [
                'name' => 'TPS PK',
                'description' => 'Pelajaran TPS PK',
                'status' => SubjectEntities::SUBJECT_STATUS_ACTIVE,
            ],
        ];

        foreach ($defaultSubject as $subject) {
            Subject::create($subject);
        }
    }
}

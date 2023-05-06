<?php

namespace Database\Seeders\Grades;

use App\Models\Grades\Grade;
use Illuminate\Database\Seeder;

class GradeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (Grade::count() > 0) {
            return;
        }

        $grade = [
            [
                'name' => 'SD',
                'description' => 'Sekolah Dasar',
            ],
            [
                'name' => 'SMP',
                'description' => 'Sekolah Menengah Pertama',
            ],
            [
                'name' => 'SMA',
                'description' => 'Sekolah Menengah Atas',
            ],
        ];

        foreach ($grade as $value) {
            Grade::create($value);
        }
    }
}

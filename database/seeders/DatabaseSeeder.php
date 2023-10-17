<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Seeders\Admin\AdminSeeder;
use Database\Seeders\Days\DaySeeder;
use Database\Seeders\Grades\GradeSeeder;
use Database\Seeders\LearningMethods\LearningMethodSeeder;
use Database\Seeders\Roles\RoleSeeder;
use Database\Seeders\Sales\SalesStatusSeeder;
use Database\Seeders\Subjects\SubjectSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,
            GradeSeeder::class,
            LearningMethodSeeder::class,
            SubjectSeeder::class,
            RoleSeeder::class,
            DaySeeder::class,
//            UserSeeder::class,
//            PaymentMethodSeeder::class,
            SalesStatusSeeder::class,
//            MentorSeeder::class,
        ]);
    }
}

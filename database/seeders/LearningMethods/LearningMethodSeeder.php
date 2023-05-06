<?php

namespace Database\Seeders\LearningMethods;

use App\Models\LearningMethods\LearningMethod;
use Illuminate\Database\Seeder;

class LearningMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if(LearningMethod::count() > 0) {
            return;
        }

        $learningMethod = [
            [
                'name' => 'Online',
                'description' => 'Online learning',
            ],
            [
                'name' => 'Offline',
                'description' => 'Offline learning',
            ],
        ];

        foreach ($learningMethod as $method) {
            LearningMethod::create($method);
        }
    }
}

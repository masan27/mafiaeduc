<?php

namespace Database\Seeders\Mentor;

use App\Entities\MentorEntities;
use App\Models\Mentors\Mentor;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class MentorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (Mentor::count() > 0) return;

        $mentorId = DB::table('mentors')->insertGetId([
            'full_name' => 'Mentor Default',
            'user_id' => 2,
            'grade_id' => 3,
            'learning_method_id' => 1,
            'photo' => 'https://via.placeholder.com/150',
            'certificate' => 'https://via.placeholder.com/150',
            'identity_card' => 'https://via.placeholder.com/150',
            'cv' => 'https://via.placeholder.com/150',
            'teaching_video' => 'https://via.placeholder.com/150',
            'phone' => '081234567890',
            'salary' => 100000,
            'status' => MentorEntities::MENTOR_STATUS_APPROVED,
            'linkedin' => 'https://www.linkedin.com/',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('mentor_credentials')->insert([
            'mentor_id' => $mentorId,
            'email' => 'mentor@email.com',
            'password' => Hash::make('mentor123'),
            'api_token' => 'daskodkpojpdj1pojd-12j0-a-wjd-jasodopasdj',
            'default_password' => 'mentor123',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}

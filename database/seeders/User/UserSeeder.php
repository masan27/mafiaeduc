<?php

namespace Database\Seeders\User;

use App\Models\Users\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (User::count() > 0) return;

        $userId = DB::table('users')->insertGetId([
            'email' => 'user@email.com',
            'password' => Hash::make('user123'),
            'role' => 3,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('user_details')->insert([
            'user_id' => $userId,
            'grade_id' => 3,
            'full_name' => 'User Default',
            'phone' => '081234567890',
            'address' => 'Jl. User Default',
            'school_origin' => 'Sutomo 1',
            'birth_date' => '2001-03-02',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $userMentorId = DB::table('users')->insertGetId([
            'email' => 'mentor@email.com',
            'password' => Hash::make('user123'),
            'role' => 2,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('user_details')->insert([
            'user_id' => $userMentorId,
            'grade_id' => 3,
            'full_name' => 'User Mentor',
            'phone' => '081234567890',
            'address' => 'Jl. User Mentor',
            'school_origin' => 'SMA Sutomo 2',
            'birth_date' => '1998-03-02',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}

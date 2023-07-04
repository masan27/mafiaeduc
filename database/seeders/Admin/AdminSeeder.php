<?php

namespace Database\Seeders\Admin;

use App\Models\Admins\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (Admin::count() > 0) return;

        Admin::create([
            'full_name' => 'Admin Default',
            'email' => 'admin@email.com',
            'password' => Hash::make('admin123'),
        ]);
    }
}

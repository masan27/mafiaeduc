<?php

namespace Database\Seeders\Roles;

use App\Models\Roles\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if(Role::count() > 0)
        {
            return;
        }

        $roles = [
            [
                'name' => 'admin',
                'description' => 'Dapat mengakses semua fitur pada admin panel',
            ],
            [
                'name' => 'mentor',
                'description' => 'Dapat mengakses semua fitur pada mentor panel',
            ],
            [
                'name' => 'student',
                'description' => 'Dapat mengakses semua fitur pada student panel',
            ],
        ];

        foreach($roles as $role) {
            Role::create($role);
        }
    }
}

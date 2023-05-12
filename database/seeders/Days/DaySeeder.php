<?php

namespace Database\Seeders\Days;

use App\Models\Days\Day;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (Day::count() > 0) return;

        $days = [
            'Senin',
            'Selasa',
            'Rabu',
            'Kamis',
            'Jumat',
            'Sabtu',
            'Minggu'
        ];

        foreach ($days as $day) {
            DB::table('days')->insert([
                'name' => $day,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

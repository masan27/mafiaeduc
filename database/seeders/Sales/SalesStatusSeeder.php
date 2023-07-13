<?php

namespace Database\Seeders\Sales;

use App\Models\Sales\SalesStatus;
use Illuminate\Database\Seeder;

class SalesStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (SalesStatus::count() > 1) {
            return;
        }

        $defaultSalesStatus = [
            [
                'name' => 'Menunggu Pembayaran',
                'description' => 'Sales Status Menunggu Pembayaran',
                'status' => 1,
            ],
            [
                'name' => 'Sedang Diproses',
                'description' => 'Sales Status Sedang Diproses',
                'status' => 1,
            ],
            [
                'name' => 'Dibayar',
                'description' => 'Sales Status Sudah Dibayar',
                'status' => 1,
            ],
            [
                'name' => 'Kadaluarsa',
                'description' => 'Sales Status Kadaluarsa',
                'status' => 1,
            ],
            [
                'name' => 'Dibatalkan',
                'description' => 'Sales Status Dibatalkan',
                'status' => 1,
            ],
            [
                'name' => 'Gagal',
                'description' => 'Sales Status Gagal',
                'status' => 1,
            ],
        ];

        foreach ($defaultSalesStatus as $salesStatus) {
            SalesStatus::create($salesStatus);
        }
    }
}

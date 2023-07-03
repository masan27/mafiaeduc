<?php

namespace Database\Seeders\Sales;

use App\Entities\SalesEntities;
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
                'status' => SalesEntities::SALES_STATUS_NOT_PAID,
            ],
            [
                'name' => 'Dibayar',
                'description' => 'Sales Status Sudah Dibayar',
                'status' => SalesEntities::SALES_STATUS_PAID,
            ],
            [
                'name' => 'Kadaluarsa',
                'description' => 'Sales Status Kadaluarsa',
                'status' => SalesEntities::SALES_STATUS_EXPIRED,
            ],
            [
                'name' => 'Dibatalkan',
                'description' => 'Sales Status Dibatalkan',
                'status' => SalesEntities::SALES_STATUS_CANCELLED,
            ],
        ];

        foreach ($defaultSalesStatus as $salesStatus) {
            SalesStatus::create($salesStatus);
        }
    }
}

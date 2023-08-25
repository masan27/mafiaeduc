<?php

namespace Database\Seeders\PaymentMethods;

use App\Models\Payments\PaymentMethod;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (PaymentMethod::count() > 0) {
            return;
        }

        $paymentMethods = [
            [
                'name' => 'BCA',
                'code' => 'bca',
                'type' => 'bank',
                'status' => 1,
                'description' => 'Bank BCA',
                'fee' => 1500,
                'account_number' => '1234567890',
            ]
        ];

        foreach ($paymentMethods as $paymentMethod) {
            PaymentMethod::create($paymentMethod);
        }
    }
}

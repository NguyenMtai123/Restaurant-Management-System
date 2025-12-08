<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CouponsTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('coupons')->insert([
            ['code' => 'WELCOME10', 'discount_type' => 'percent', 'discount_value' => 10, 'min_order' => 100000, 'start_date' => '2025-01-01', 'end_date' => '2025-12-31'],
            ['code' => 'FREESHIP', 'discount_type' => 'fixed', 'discount_value' => 15000, 'min_order' => 150000, 'start_date' => '2025-01-01', 'end_date' => '2025-12-31'],
            ['code' => 'SAVE20', 'discount_type' => 'percent', 'discount_value' => 20, 'min_order' => 200000, 'start_date' => '2025-01-01', 'end_date' => '2025-06-30'],
            ['code' => 'HOLIDAY15', 'discount_type' => 'percent', 'discount_value' => 15, 'min_order' => 120000, 'start_date' => '2025-12-01', 'end_date' => '2025-12-31'],
            ['code' => 'CASHBACK5', 'discount_type' => 'fixed', 'discount_value' => 5000, 'min_order' => 50000, 'start_date' => '2025-01-01', 'end_date' => '2025-12-31'],
        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentsTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('payments')->insert([
            ['order_id' => 1, 'method' => 'vnpay', 'amount' => 279000, 'status' => 'paid'],
            ['order_id' => 2, 'method' => 'cod', 'amount' => 80000, 'status' => 'pending'],
            ['order_id' => 3, 'method' => 'vnpay', 'amount' => 220000, 'status' => 'paid'],
            ['order_id' => 4, 'method' => 'vnpay', 'amount' => 135000, 'status' => 'pending'],
            ['order_id' => 5, 'method' => 'vnpay', 'amount' => 70000, 'status' => 'failed'],
        ]);
    }
}

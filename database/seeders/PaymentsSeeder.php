<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentsSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('payments')->insert([
            [
                'order_id' => 1,
                'method' => 'cash',
                'amount' => 297000,
                'status' => 'paid',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'order_id' => 2,
                'method' => 'cash',
                'amount' => 148500,
                'status' => 'pending',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'order_id' => 3,
                'method' => 'online',
                'amount' => 110000,
                'status' => 'paid',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

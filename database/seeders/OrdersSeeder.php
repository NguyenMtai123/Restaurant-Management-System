<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrdersSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('orders')->insert([
            [
                'order_number' => 'ORD001',
                'user_id' => 1,
                'subtotal' => 270000,
                'tax' => 27000,
                'total_amount' => 297000,
                'status' => 'pending',      // sửa từ 'pending' OK
                'notes' => 'Không dùng đồ uống có ga',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'order_number' => 'ORD002',
                'user_id' => 2,
                'subtotal' => 135000,
                'tax' => 13500,
                'total_amount' => 148500,
                'status' => 'delivered',    // sửa từ 'confirmed' → 'delivered'
                'notes' => '',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'order_number' => 'ORD003',
                'user_id' => 3,
                'subtotal' => 100000,
                'tax' => 10000,
                'total_amount' => 110000,
                'status' => 'completed',
                'notes' => 'Giao hàng nhanh',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

    }
}

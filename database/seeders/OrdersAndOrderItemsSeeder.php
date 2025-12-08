<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrdersAndOrderItemsSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('orders')->insert([
            [
                'user_id' => 4,
                'order_type' => 'delivery',
                'table_id' => null,
                'total' => 310000,
                'discount' => 31000,
                'final_total' => 279000,
                'status' => 'completed',
                'address' => '101 Customer Street',
                'shipping_zone_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 4,
                'order_type' => 'takeaway',
                'table_id' => null,
                'total' => 80000,
                'discount' => 0,
                'final_total' => 80000,
                'status' => 'delivering',
                'address' => '101 Customer Street',
                'shipping_zone_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 5,
                'order_type' => 'delivery',
                'table_id' => null,
                'total' => 220000,
                'discount' => 0,
                'final_total' => 220000,
                'status' => 'preparing',
                'address' => '202 Customer Street',
                'shipping_zone_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 5,
                'order_type' => 'dine-in',
                'table_id' => 2,
                'total' => 150000,
                'discount' => 15000,
                'final_total' => 135000,
                'status' => 'pending',
                'address' => '202 Customer Street',
                'shipping_zone_id' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 4,
                'order_type' => 'dine-in',
                'table_id' => 1,
                'total' => 70000,
                'discount' => 0,
                'final_total' => 70000,
                'status' => 'cancelled',
                'address' => '101 Customer Street',
                'shipping_zone_id' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        DB::table('order_items')->insert([
            ['order_id' => 1, 'item_id' => 1, 'quantity' => 2, 'price' => 120000, 'created_at' => now(), 'updated_at' => now()],
            ['order_id' => 1, 'item_id' => 3, 'quantity' => 1, 'price' => 80000, 'created_at' => now(), 'updated_at' => now()],
            ['order_id' => 2, 'item_id' => 2, 'quantity' => 1, 'price' => 150000, 'created_at' => now(), 'updated_at' => now()],
            ['order_id' => 3, 'item_id' => 4, 'quantity' => 2, 'price' => 110000, 'created_at' => now(), 'updated_at' => now()],
            ['order_id' => 4, 'item_id' => 5, 'quantity' => 1, 'price' => 70000, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}

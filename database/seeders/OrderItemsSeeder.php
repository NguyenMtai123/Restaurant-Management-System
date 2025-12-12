<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderItemsSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('order_items')->insert([
            ['order_id' => 1, 'menu_item_id' => 1, 'quantity' => 2, 'unit_price' => 120000, 'notes' => '', 'created_at' => now(), 'updated_at' => now()],
            ['order_id' => 1, 'menu_item_id' => 4, 'quantity' => 1, 'unit_price' => 30000, 'notes' => '', 'created_at' => now(), 'updated_at' => now()],

            ['order_id' => 2, 'menu_item_id' => 2, 'quantity' => 3, 'unit_price' => 45000, 'notes' => '', 'created_at' => now(), 'updated_at' => now()],

            ['order_id' => 3, 'menu_item_id' => 5, 'quantity' => 2, 'unit_price' => 50000, 'notes' => 'Gói riêng', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}

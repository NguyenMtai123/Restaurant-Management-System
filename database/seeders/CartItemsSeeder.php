<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CartItemsSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('cart_items')->insert([
            ['cart_id' => 1, 'item_id' => 1, 'quantity' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['cart_id' => 1, 'item_id' => 4, 'quantity' => 1, 'created_at' => now(), 'updated_at' => now()],

            ['cart_id' => 2, 'item_id' => 2, 'quantity' => 3, 'created_at' => now(), 'updated_at' => now()],

            ['cart_id' => 3, 'item_id' => 5, 'quantity' => 2, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}

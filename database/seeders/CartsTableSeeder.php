<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CartsTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('carts')->insert([
            ['user_id' => 4],
            ['user_id' => 5],
        ]);

        DB::table('cart_items')->insert([
            ['cart_id' => 1, 'item_id' => 1, 'quantity' => 2],
            ['cart_id' => 1, 'item_id' => 3, 'quantity' => 1],
            ['cart_id' => 2, 'item_id' => 2, 'quantity' => 1],
            ['cart_id' => 2, 'item_id' => 4, 'quantity' => 2],
            ['cart_id' => 2, 'item_id' => 5, 'quantity' => 1],
        ]);
    }
}

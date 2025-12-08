<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuItemsTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('menu_items')->insert([
            ['category_id' => 1, 'name' => 'Margherita Pizza', 'price' => 120000, 'slug' => 'pizza-margherita', 'image' => 'pizza_margherita.jpg'],
            ['category_id' => 1, 'name' => 'Pepperoni Pizza', 'price' => 150000, 'slug' => 'pizza-pepperoni', 'image' => 'pizza_pepperoni.jpg'],
            ['category_id' => 2, 'name' => 'Classic Burger', 'price' => 80000, 'slug' => 'burger-classic', 'image' => 'burger_classic.jpg'],
            ['category_id' => 3, 'name' => 'Spaghetti Carbonara', 'price' => 110000, 'slug' => 'pasta-carbonara', 'image' => 'pasta_carbonara.jpg'],
            ['category_id' => 4, 'name' => 'Caesar Salad', 'price' => 70000, 'slug' => 'salad-caesar', 'image' => 'salad_caesar.jpg'],
        ]);
    }
}

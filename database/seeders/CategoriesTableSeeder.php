<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('categories')->insert([
            ['name' => 'Pizza', 'slug' => 'pizza'],
            ['name' => 'Burger', 'slug' => 'burger'],
            ['name' => 'Pasta', 'slug' => 'pasta'],
            ['name' => 'Salad', 'slug' => 'salad'],
            ['name' => 'Drinks', 'slug' => 'drinks'],
        ]);
    }
}

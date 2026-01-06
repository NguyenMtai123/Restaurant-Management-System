<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuItemImagesSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('menu_item_images')->insert([
            ['menu_item_id' => 1, 'image_path' => 'images/menu/ga-ran.png', 'is_featured' => true, 'created_at' => now(), 'updated_at' => now()],
            ['menu_item_id' => 2, 'image_path' => 'images/menu/food_2.png', 'is_featured' => true, 'created_at' => now(), 'updated_at' => now()],
            ['menu_item_id' => 3, 'image_path' => 'images/menu/food_17.png', 'is_featured' => true, 'created_at' => now(), 'updated_at' => now()],
            ['menu_item_id' => 4, 'image_path' => 'images/menu/ca-phe-sua.jpg', 'is_featured' => true, 'created_at' => now(), 'updated_at' => now()],
            ['menu_item_id' => 5, 'image_path' => 'images/menu/khoai-tay-chien.png', 'is_featured' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}

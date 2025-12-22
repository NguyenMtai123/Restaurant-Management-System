<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuItemImagesSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('menu_item_images')->insert([
            ['menu_item_id' => 1, 'image_path' => 'images/ga-ran.jpg', 'is_featured' => true, 'created_at' => now(), 'updated_at' => now()],
            ['menu_item_id' => 2, 'image_path' => 'images/salad-tron.jpg', 'is_featured' => true, 'created_at' => now(), 'updated_at' => now()],
            ['menu_item_id' => 3, 'image_path' => 'images/kem-vani.jpg', 'is_featured' => true, 'created_at' => now(), 'updated_at' => now()],
            ['menu_item_id' => 4, 'image_path' => 'images/ca-phe-sua.jpg', 'is_featured' => true, 'created_at' => now(), 'updated_at' => now()],
            ['menu_item_id' => 5, 'image_path' => 'images/khoai-tay-chien.jpg', 'is_featured' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}

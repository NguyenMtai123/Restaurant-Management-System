<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuCategoriesSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('menu_categories')->insert([
            ['name' => 'Món chính', 'slug' => 'mon-chinh', 'description' => 'Các món chính', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Món khai vị', 'slug' => 'mon-khai-vi', 'description' => 'Các món khai vị', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Món tráng miệng', 'slug' => 'mon-trang-mieng', 'description' => 'Các món tráng miệng', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Đồ uống', 'slug' => 'do-uong', 'description' => 'Các loại đồ uống', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Món ăn nhẹ', 'slug' => 'mon-an-nhe', 'description' => 'Các món ăn nhẹ', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}

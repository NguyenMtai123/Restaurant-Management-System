<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuItemsSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('menu_items')->insert([
            [
                'code' => 'SP001',
                'name' => 'Gà rán',
                'description' => 'Gà rán giòn, thơm ngon',
                'price' => 120000,
                'category_id' => 1, // Món chính
                'slug' => 'ga-ran',
                'is_available' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'code' => 'SP002',
                'name' => 'Salad trộn',
                'description' => 'Rau củ trộn tươi mát',
                'price' => 45000,
                'category_id' => 2, // Món khai vị
                'slug' => 'salad-tron',
                'is_available' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'code' => 'SP003',
                'name' => 'Kem vani',
                'description' => 'Kem vani mát lạnh',
                'price' => 35000,
                'category_id' => 3, // Món tráng miệng
                'slug' => 'kem-vani',
                'is_available' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'code' => 'SP004',
                'name' => 'Cà phê sữa',
                'description' => 'Cà phê đậm đà',
                'price' => 30000,
                'category_id' => 4, // Đồ uống
                'slug' => 'ca-phe-sua',
                'is_available' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'code' => 'SP005',
                'name' => 'Khoai tây chiên',
                'description' => 'Giòn rụm, ăn kèm nước sốt',
                'price' => 50000,
                'category_id' => 5, // Món ăn nhẹ
                'slug' => 'khoai-tay-chien',
                'is_available' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RestaurantsSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('restaurants')->insert([
            ['name' => 'Nhà hàng A', 'address' => '123 Đường A, TP.HCM', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Nhà hàng B', 'address' => '456 Đường B, Hà Nội', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Nhà hàng C', 'address' => '789 Đường C, Đà Nẵng', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}

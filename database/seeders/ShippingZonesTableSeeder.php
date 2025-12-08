<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ShippingZonesTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('shipping_zones')->insert([
            ['zone_name' => 'Phường Nha Trang', 'shipping_fee' => 15000, 'free_threshold' => 200000],
            ['zone_name' => 'Phường Tây Nha Trang', 'shipping_fee' => 20000, 'free_threshold' => 250000],
            ['zone_name' => 'Phường Bắc Nha Trang', 'shipping_fee' => 25000, 'free_threshold' => 300000],
            ['zone_name' => 'Phường Nam Nha Trang', 'shipping_fee' => 30000, 'free_threshold' => 350000],
        ]);
    }
}

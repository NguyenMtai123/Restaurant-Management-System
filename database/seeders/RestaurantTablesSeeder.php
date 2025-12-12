<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RestaurantTablesSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('restaurant_tables')->insert([
            [
                'table_name' => 'Bàn 1',
                'seats' => 2,
                'status' => 'available',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'table_name' => 'Bàn 2',
                'seats' => 4,
                'status' => 'available',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'table_name' => 'Bàn 3',
                'seats' => 6,
                'status' => 'available',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}

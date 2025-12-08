<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TablesAndReservationsSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('tables')->insert([
            ['table_name' => 'Table 1', 'capacity' => 4],
            ['table_name' => 'Table 2', 'capacity' => 2],
            ['table_name' => 'Table 3', 'capacity' => 6],
        ]);

        DB::table('reservations')->insert([
            ['user_id' => 4, 'table_id' => 1, 'reservation_time' => '2025-12-10 18:00:00', 'status' => 'confirmed'],
            ['user_id' => 5, 'table_id' => 2, 'reservation_time' => '2025-12-12 12:00:00', 'status' => 'pending'],
        ]);
    }
}

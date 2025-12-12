<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CartsSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('carts')->insert([
            ['user_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 3, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}

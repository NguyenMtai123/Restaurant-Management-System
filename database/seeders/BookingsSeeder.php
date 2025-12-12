<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookingsSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('bookings')->insert([
            [
                'user_id' => 1,
                'table_id' => 1,
                'booking_date' => '2025-12-12',
                'booking_time' => '18:00:00',
                'number_of_guests' => 2,
                'deposit_fee' => 50000,
                'deposit_paid' => true,
                'special_requests' => 'Cần ghế trẻ em',
                'status' => 'confirmed',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 2,
                'table_id' => 2,
                'booking_date' => '2025-12-13',
                'booking_time' => '19:00:00',
                'number_of_guests' => 4,
                'deposit_fee' => 100000,
                'deposit_paid' => false,
                'special_requests' => 'Gần cửa sổ',
                'status' => 'pending',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 3,
                'table_id' => 3,
                'booking_date' => '2025-12-14',
                'booking_time' => '20:00:00',
                'number_of_guests' => 6,
                'deposit_fee' => 150000,
                'deposit_paid' => true,
                'special_requests' => 'Bữa tiệc sinh nhật',
                'status' => 'confirmed',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

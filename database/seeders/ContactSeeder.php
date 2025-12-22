<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContactSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('contacts')->insert([
            [
                'name' => 'Nguyễn Văn A',
                'email' => 'vana@gmail.com',
                'phone' => '0912345678',
                'subject' => 'Hỏi về đặt bàn',
                'message' => 'Nhà hàng có nhận đặt bàn cho 10 người không?',
                'is_read' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Trần Thị B',
                'email' => 'thib@gmail.com',
                'phone' => '0987654321',
                'subject' => 'Góp ý',
                'message' => 'Món ăn rất ngon, phục vụ tốt!',
                'is_read' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

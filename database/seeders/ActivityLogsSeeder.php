<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ActivityLogsSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('activity_logs')->truncate(); // xóa dữ liệu cũ nếu có

        DB::table('activity_logs')->insert([
            [
                'user_id' => 1,
                'action' => 'Đăng nhập hệ thống',
                'ip_address' => '192.168.1.10',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 2,
                'action' => 'Thêm món mới vào giỏ hàng',
                'ip_address' => '192.168.1.11',
                'user_agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7)',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 3,
                'action' => 'Đặt bàn thành công',
                'ip_address' => '192.168.1.12',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

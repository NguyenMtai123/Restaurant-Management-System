<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AboutSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('abouts')->insert([
            [
                'title' => 'Giới thiệu nhà hàng',
                'content_contact' => 'Nhà hàng chúng tôi chuyên phục vụ các món ăn chất lượng cao, nguyên liệu tươi ngon, không gian ấm cúng và dịch vụ chuyên nghiệp.',
                'image' => 'abouts/about.jpg',
                'address' => '123 Nguyễn Văn A, Quận 1, TP.HCM',
                'map_embed' => '<iframe src="https://www.google.com/maps/embed?pb=!1m18..." width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>',
                'phone' => '0909123456',
                'email' => 'contact@restaurant.com',
                'is_used' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}

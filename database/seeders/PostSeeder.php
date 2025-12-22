<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('posts')->insert([
            [
                'code' => 'POST001',
                'title' => 'Khai trương nhà hàng',
                'slug' => Str::slug('Khai trương nhà hàng'),
                'excerpt' => 'Nhà hàng chính thức khai trương với nhiều ưu đãi hấp dẫn.',
                'content_post' => 'Chúng tôi rất vui mừng thông báo nhà hàng chính thức khai trương...',
                'thumbnail' => 'posts/post1.jpg',
                'post_category_id' => 1, // Tin tức
                'is_published' => true,
                'published_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'POST002',
                'title' => 'Ưu đãi tuần lễ vàng',
                'slug' => Str::slug('Ưu đãi tuần lễ vàng'),
                'excerpt' => 'Giảm giá lên đến 30% cho tất cả món ăn.',
                'content_post' => 'Tuần lễ vàng với nhiều ưu đãi dành cho khách hàng...',
                'thumbnail' => 'posts/post2.jpg',
                'post_category_id' => 2, // Khuyến mãi
                'is_published' => true,
                'published_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'POST003',
                'title' => 'Bí quyết chọn nguyên liệu tươi',
                'slug' => Str::slug('Bí quyết chọn nguyên liệu tươi'),
                'excerpt' => 'Cách chọn nguyên liệu tươi ngon cho bữa ăn.',
                'content_post' => 'Nguyên liệu tươi là yếu tố quan trọng nhất...',
                'thumbnail' => 'posts/post3.jpg',
                'post_category_id' => 3, // Blog ẩm thực
                'is_published' => true,
                'published_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

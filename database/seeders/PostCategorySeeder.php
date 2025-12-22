<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PostCategorySeeder extends Seeder
{
    public function run(): void
    {
        DB::table('post_categories')->insert([
            [
                'name' => 'Tin tức',
                'slug' => Str::slug('Tin tức'),
                'description' => 'Tin tức mới nhất của nhà hàng',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Khuyến mãi',
                'slug' => Str::slug('Khuyến mãi'),
                'description' => 'Chương trình ưu đãi hấp dẫn',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Blog ẩm thực',
                'slug' => Str::slug('Blog ẩm thực'),
                'description' => 'Chia sẻ kiến thức ẩm thực',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Thông báo',
                'slug' => Str::slug('Thông báo'),
                'description' => 'Thông báo từ hệ thống',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

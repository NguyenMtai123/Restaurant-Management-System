<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CommentsSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('comments')->insert([
            ['user_id' => 1, 'parent_id' => null, 'content' => 'Món ăn ngon, phục vụ nhanh', 'commentable_type' => 'menu_item', 'commentable_id' => 1, 'rating' => 5, 'is_approved' => true, 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 2, 'parent_id' => null, 'content' => 'Không gian thoáng mát', 'commentable_type' => 'restaurant', 'commentable_id' => 1, 'rating' => 4, 'is_approved' => true, 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 3, 'parent_id' => null, 'content' => 'Đồ uống ngon, giá hợp lý', 'commentable_type' => 'menu_item', 'commentable_id' => 4, 'rating' => 4, 'is_approved' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}

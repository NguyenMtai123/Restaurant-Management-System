<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReviewsTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('reviews')->insert([
            ['order_id' => 1, 'user_id' => 4, 'item_id' => 1, 'rating' => 5, 'comment' => 'Pizza rất ngon, phô mai nhiều!'],
            ['order_id' => 1, 'user_id' => 4, 'item_id' => 3, 'rating' => 4, 'comment' => 'Burger ngon nhưng hơi nhỏ'],
            ['order_id' => 3, 'user_id' => 5, 'item_id' => 4, 'rating' => 5, 'comment' => 'Pasta hoàn hảo, sẽ order lại!'],
            ['order_id' => 2, 'user_id' => 4, 'item_id' => 2, 'rating' => 3, 'comment' => 'Pizza được nhưng thiếu topping'],
            ['order_id' => 4, 'user_id' => 5, 'item_id' => 5, 'rating' => 4, 'comment' => 'Salad tươi ngon, dressing vừa miệng'],
        ]);
    }
}

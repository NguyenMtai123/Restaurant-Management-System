<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Categories và Items trước vì item phụ thuộc vào category
        $this->call([
            MenuCategoriesSeeder::class,
            MenuItemsSeeder::class,
            MenuItemImagesSeeder::class,
        ]);

        // 2. Users, Restaurants, Tables
        $this->call([
            UsersTableSeeder::class,
        ]);

        // 4. Cart và CartItem (cần user và menu_items)
        $this->call([
            CartsSeeder::class,
            CartItemsSeeder::class,
        ]);

        // 5. Orders và OrderItems (cần user, booking, menu_items)
        $this->call([
            OrdersSeeder::class,
            OrderItemsSeeder::class,
        ]);

        // 6. Payments (cần order)
        $this->call([
            PaymentsSeeder::class,
        ]);

        // 7. Comments (cần user, menu_items, restaurant)
        $this->call([
            CommentsSeeder::class,
        ]);

        $this->call([
            ActivityLogsSeeder::class
        ]);

        $this->call([
            PostCategorySeeder::class,
            PostSeeder::class,
        ]);

         $this->call([
            AboutSeeder::class,
            ContactSeeder::class,
            FavoriteSeeder::class,
        ]);
    }
}

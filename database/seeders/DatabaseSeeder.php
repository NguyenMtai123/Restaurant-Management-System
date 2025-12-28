<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        /**
         * =========================
         * 1. RBAC (BẮT BUỘC TRƯỚC)
         * =========================
         */
        $this->call([
            RoleSeeder::class,
            PermissionSeeder::class,
            RolePermissionSeeder::class,
        ]);

        /**
         * =========================
         * 2. USERS (CẦN ROLE)
         * =========================
         */
        $this->call([
            UsersTableSeeder::class,
        ]);

        /**
         * =========================
         * 3. MENU & CATEGORY
         * =========================
         */
        $this->call([
            MenuCategoriesSeeder::class,
            MenuItemsSeeder::class,
            MenuItemImagesSeeder::class,
        ]);

        /**
         * =========================
         * 4. CART
         * =========================
         */
        $this->call([
            CartsSeeder::class,
            CartItemsSeeder::class,
        ]);

        /**
         * =========================
         * 5. ORDERS
         * =========================
         */
        $this->call([
            OrdersSeeder::class,
            OrderItemsSeeder::class,
        ]);

        /**
         * =========================
         * 6. PAYMENTS
         * =========================
         */
        $this->call([
            PaymentsSeeder::class,
        ]);

        /**
         * =========================
         * 7. COMMENTS
         * =========================
         */
        $this->call([
            CommentsSeeder::class,
        ]);

        /**
         * =========================
         * 8. POSTS
         * =========================
         */
        $this->call([
            PostCategorySeeder::class,
            PostSeeder::class,
        ]);

        /**
         * =========================
         * 9. ABOUT + CONTACT
         * =========================
         */
        $this->call([
            AboutSeeder::class,
            ContactSeeder::class,
        ]);
    }
}

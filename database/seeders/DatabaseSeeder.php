<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

       $this->call([
            UsersTableSeeder::class,
            // CategoriesTableSeeder::class,
            // MenuItemsTableSeeder::class,
            // CartsTableSeeder::class,
            // CouponsTableSeeder::class,
            // ShippingZonesTableSeeder::class,
            // TablesAndReservationsSeeder::class,
            // OrdersAndOrderItemsSeeder::class,
            // PaymentsTableSeeder::class,
            // ReviewsTableSeeder::class,
        ]);

    }
}

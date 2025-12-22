<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password123'), // password
                'phone' => '0987654321',
                'address' => '123 Admin Street',
                'avatar' => null,
                'role' => 'admin',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Staff User',
                'email' => 'staff@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password123'),
                'phone' => '0987654322',
                'address' => '456 Staff Street',
                'avatar' => null,
                'role' => 'staff',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Customer One',
                'email' => 'customer1@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password123'),
                'phone' => '0987654323',
                'address' => '789 Customer Street',
                'avatar' => null,
                'role' => 'customer',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Customer Two',
                'email' => 'customer2@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password123'),
                'phone' => '0987654324',
                'address' => '101 Customer Street',
                'avatar' => null,
                'role' => 'customer',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Customer Three',
                'email' => 'customer3@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password123'),
                'phone' => '0987654325',
                'address' => '202 Customer Street',
                'avatar' => null,
                'role' => 'customer',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}

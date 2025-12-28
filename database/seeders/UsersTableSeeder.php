<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole    = Role::where('name', 'admin')->firstOrFail();
        $staffRole    = Role::where('name', 'staff')->firstOrFail();
        $customerRole = Role::where('name', 'customer')->firstOrFail();

        User::insert([
            [
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password123'),
                'phone' => '0987654321',
                'address' => '123 Admin Street',
                'avatar' => null,
                'role_id' => $adminRole->id,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Staff User',
                'email' => 'staff@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password123'),
                'phone' => '0987654322',
                'address' => '456 Staff Street',
                'avatar' => null,
                'role_id' => $staffRole->id,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Customer One',
                'email' => 'customer1@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password123'),
                'phone' => '0987654323',
                'address' => '789 Customer Street',
                'avatar' => null,
                'role_id' => $customerRole->id,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Customer Two',
                'email' => 'customer2@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password123'),
                'phone' => '0987654324',
                'address' => '101 Customer Street',
                'avatar' => null,
                'role_id' => $customerRole->id,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Customer Three',
                'email' => 'customer3@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password123'),
                'phone' => '0987654325',
                'address' => '202 Customer Street',
                'avatar' => null,
                'role_id' => $customerRole->id,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

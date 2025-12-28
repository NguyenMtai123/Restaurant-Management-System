<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        Role::insert([
            [
                'name' => 'admin',
                'label' => 'Quản trị viên',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'staff',
                'label' => 'Nhân viên',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'customer',
                'label' => 'Khách hàng',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

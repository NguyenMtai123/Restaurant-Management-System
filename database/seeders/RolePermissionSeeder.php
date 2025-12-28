<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        $admin = Role::where('name', 'admin')->first();
        $staff = Role::where('name', 'staff')->first();
        $customer = Role::where('name', 'customer')->first();

        // ADMIN: toàn quyền
        $admin->permissions()->sync(
            Permission::pluck('id')->toArray()
        );

        // STAFF: CHỈ dashboard + statistics
        $staff->permissions()->sync(
            Permission::whereIn('key', [
                'view_dashboard',
                'view_statistics',
                'manage_orders',
                'manage_menu',
                'manage_coupons',
                'manage_settings',
            ])->pluck('id')->toArray()
        );

        // CUSTOMER: không có quyền admin
        $customer->permissions()->sync([]);
    }
}

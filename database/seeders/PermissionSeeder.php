<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            ['key' => 'view_dashboard',   'label' => 'Xem dashboard'],
            ['key' => 'view_statistics',  'label' => 'Xem thống kê'],

            ['key' => 'manage_users',     'label' => 'Quản lý người dùng'],
            ['key' => 'manage_orders',    'label' => 'Quản lý đơn hàng'],
            ['key' => 'manage_menu',      'label' => 'Quản lý menu & danh mục'],
            ['key' => 'manage_coupons',   'label' => 'Quản lý mã giảm giá'],
            ['key' => 'manage_employees', 'label' => 'Quản lý nhân viên'],
            ['key' => 'manage_contacts',  'label' => 'Quản lý liên hệ'],
            ['key' => 'manage_settings',  'label' => 'Quản lý cấu hình'],
            ['key' => 'manage_roles',     'label' => 'Quản lý vai trò'],
            ['key' => 'about_settings',   'label' => 'Cấu hình trang giới thiệu'],

        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(
                ['key' => $permission['key']],
                ['label' => $permission['label']]
            );
        }
    }
}

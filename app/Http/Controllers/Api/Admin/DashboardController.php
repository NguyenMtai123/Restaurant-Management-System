<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $customerRoleId = Role::where('name','customer')->value('id');

        // THỐNG KÊ TỔNG QUAN
        $totalOrders = Order::where('status','completed')->count();
        $totalRevenue = Order::where('status','completed')->sum('total_amount');
        $pendingOrders = Order::where('status','pending')->count();

        $totalCustomers = User::where('role_id',$customerRoleId)->count();

        // DOANH THU TUẦN
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek   = Carbon::now()->endOfWeek();

        $weeklyRevenue = [];
        for ($i = 0; $i < 7; $i++) {
            $day = $startOfWeek->copy()->addDays($i);

            $weeklyRevenue[] = Order::where('status','completed')
                ->whereDate('created_at', $day)
                ->sum('total_amount');
        }

        // DOANH THU THÁNG
        $startOfMonth = Carbon::now()->startOfMonth();
        $daysInMonth  = $startOfMonth->daysInMonth;

        $monthlyRevenue = [];
        for ($i = 0; $i < $daysInMonth; $i++) {
            $day = $startOfMonth->copy()->addDays($i);

            $monthlyRevenue[] = Order::where('status','completed')
                ->whereDate('created_at', $day)
                ->sum('total_amount');
        }

        // DOANH THU NĂM (THEO THÁNG)
        $yearlyRevenue = [];

        for ($month = 1; $month <= 12; $month++) {
            $yearlyRevenue[] = Order::where('status','completed')
                ->whereYear('created_at', now()->year)
                ->whereMonth('created_at', $month)
                ->sum('total_amount');
        }

        // ĐƠN GẦN ĐÂY
        $recentOrders = Order::latest()->limit(5)->get();

        return view('admin.dashboard', compact(
            'totalOrders',
            'totalRevenue',
            'totalCustomers',
            'pendingOrders',
            'weeklyRevenue',
            'monthlyRevenue',
            'yearlyRevenue',
            'recentOrders'
        ));
    }
}

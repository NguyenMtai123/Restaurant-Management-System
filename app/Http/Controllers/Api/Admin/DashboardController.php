<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // -------------------------
        // Thống kê tổng quan (chỉ đơn hoàn thành)
        // -------------------------
        $completedOrders = Order::where('status', 'completed');
        $totalOrders = $completedOrders->count();
        $totalRevenue = $completedOrders->sum('total_amount');
        $totalCustomers = User::where('role','customer')->count();
        $pendingOrders = Order::where('status','pending')->count();

        // -------------------------
        // Doanh thu tuần (chỉ đơn hoàn thành)
        // -------------------------
        $startOfWeek = Carbon::now()->startOfWeek(); // thứ 2
        $endOfWeek = Carbon::now()->endOfWeek();
        $ordersWeek = Order::whereBetween('created_at', [$startOfWeek, $endOfWeek])
                           ->where('status','completed')
                           ->get();

        $weeklyRevenue = [];
        for($i=0; $i<7; $i++){
            $day = $startOfWeek->copy()->addDays($i);
            $weeklyRevenue[] = $ordersWeek->where('created_at','>=',$day->startOfDay())
                                          ->where('created_at','<=',$day->endOfDay())
                                          ->sum('total_amount');
        }

        // -------------------------
        // Doanh thu tháng (chỉ đơn hoàn thành)
        // -------------------------
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();
        $ordersMonth = Order::whereBetween('created_at', [$startOfMonth, $endOfMonth])
                            ->where('status','completed')
                            ->get();

        $monthlyRevenue = [];
        $daysInMonth = $startOfMonth->daysInMonth;
        for($i=0; $i<$daysInMonth; $i++){
            $day = $startOfMonth->copy()->addDays($i);
            $monthlyRevenue[] = $ordersMonth->where('created_at','>=',$day->startOfDay())
                                           ->where('created_at','<=',$day->endOfDay())
                                           ->sum('total_amount');
        }

        // -------------------------
        // Doanh thu năm (theo tháng - chỉ đơn hoàn thành)
        // -------------------------
        $startOfYear = Carbon::now()->startOfYear();
        $endOfYear   = Carbon::now()->endOfYear();

        $ordersYear = Order::whereBetween('created_at', [$startOfYear, $endOfYear])
            ->where('status', 'completed')
            ->get();

        $yearlyRevenue = [];

        for ($month = 1; $month <= 12; $month++) {
            $yearlyRevenue[] = $ordersYear
                ->filter(function ($order) use ($month) {
                    return Carbon::parse($order->created_at)->month === $month;
                })
                ->sum('total_amount');
        }


        // -------------------------
        // Đơn hàng gần đây (có thể hiển thị tất cả hoặc chỉ hoàn thành)
        // -------------------------
        $recentOrders = Order::orderBy('created_at','desc')->limit(5)->get();

        return view('admin.dashboard', compact(
            'totalOrders',
            'totalRevenue',
            'totalCustomers',
            'pendingOrders',
            'weeklyRevenue',
            'monthlyRevenue',
            'yearlyRevenue', // 👈 thêm
            'recentOrders'
        ));

    }
}

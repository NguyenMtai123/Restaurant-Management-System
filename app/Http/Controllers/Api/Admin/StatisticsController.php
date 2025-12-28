<?php

namespace App\Http\Controllers\Api\Admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class StatisticsController extends Controller
{
    public function index(Request $request)
    {
        // Validate date range
        if ($request->filled('from') && $request->filled('to')) {
            if (Carbon::parse($request->from)->gt(Carbon::parse($request->to))) {
                return redirect()->back()->withInput()->with('error', 'Ngày bắt đầu phải nhỏ hơn hoặc bằng ngày kết thúc');
            }
        }

        $from = $request->from ? Carbon::parse($request->from)->startOfDay() : Carbon::now()->startOfMonth();
        $to   = $request->to   ? Carbon::parse($request->to)->endOfDay()   : Carbon::now()->endOfDay();

        // Basic KPIs (existing)
        $totalRevenue = DB::table('orders')
            ->whereBetween('created_at', [$from, $to])
            ->where('status', 'completed')
            ->sum('total_amount');

        $totalOrders = DB::table('orders')
            ->whereBetween('created_at', [$from, $to])
            ->where('status', 'completed')
            ->count();

        $totalItems = DB::table('order_items')
            ->join('orders', 'orders.id', '=', 'order_items.order_id')
            ->whereBetween('orders.created_at', [$from, $to])
            ->where('orders.status', 'completed')
            ->sum('order_items.quantity');

        $cancelOrders = DB::table('orders')
            ->whereBetween('created_at', [$from, $to])
            ->where('status', 'cancelled')
            ->count();

        $cancelRate = ($cancelOrders + $totalOrders) > 0
            ? round($cancelOrders / ($cancelOrders + $totalOrders) * 100, 2)
            : 0;

        // --- SERIES: last 7 days (labels + current + previous 7 days) ---
        $labels7 = [];
        $data7 = [];
        $prev7 = [];

        // build current 7 days (6 days ago -> today)
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $labels7[] = $date->format('d/m');
            $amount = DB::table('orders')
                ->whereDate('created_at', $date)
                ->where('status', 'completed')
                ->sum('total_amount');
            $data7[] = (float)$amount;
        }

        // previous 7-day window (7-13 days ago)
        for ($i = 13; $i >= 7; $i--) {
            $date = Carbon::today()->subDays($i);
            $amount = DB::table('orders')
                ->whereDate('created_at', $date)
                ->where('status', 'completed')
                ->sum('total_amount');
            $prev7[] = (float)$amount;
        }

        // --- SERIES: last 8 weeks (week labels) ---
        $labels8w = [];
        $data8w = [];
        $prev8w = [];
        // current 8 weeks: from 7 weeks ago -> this week
        for ($wk = 7; $wk >= 0; $wk--) {
            $start = Carbon::now()->startOfWeek()->subWeeks($wk);
            $end   = (clone $start)->endOfWeek();
            $labels8w[] = $start->format('d/m');
            $sum = DB::table('orders')
                ->whereBetween('created_at', [$start->startOfDay(), $end->endOfDay()])
                ->where('status', 'completed')
                ->sum('total_amount');
            $data8w[] = (float)$sum;
        }
        // previous 8 weeks (the 8 weeks immediately before those)
        for ($wk = 15; $wk >= 8; $wk--) {
            $start = Carbon::now()->startOfWeek()->subWeeks($wk);
            $end   = (clone $start)->endOfWeek();
            $sum = DB::table('orders')
                ->whereBetween('created_at', [$start->startOfDay(), $end->endOfDay()])
                ->where('status', 'completed')
                ->sum('total_amount');
            $prev8w[] = (float)$sum;
        }

        // --- SERIES: last 12 months ---
        $labels12 = [];
        $data12 = [];
        $prev12 = [];
        for ($m = 11; $m >= 0; $m--) {
            $start = Carbon::now()->subMonths($m)->startOfMonth();
            $end = Carbon::now()->subMonths($m)->endOfMonth();
            $labels12[] = $start->format('M Y');
            $sum = DB::table('orders')
                ->whereBetween('created_at', [$start, $end])
                ->where('status', 'completed')
                ->sum('total_amount');
            $data12[] = (float)$sum;
        }
        // previous 12 months (months -12 to -23)
        for ($m = 23; $m >= 12; $m--) {
            $start = Carbon::now()->subMonths($m)->startOfMonth();
            $end = Carbon::now()->subMonths($m)->endOfMonth();
            $sum = DB::table('orders')
                ->whereBetween('created_at', [$start, $end])
                ->where('status', 'completed')
                ->sum('total_amount');
            $prev12[] = (float)$sum;
        }

        // QUICK COMPARISONS: totals for today/yesterday, week, month (for delta %)
        $today = Carbon::today();
        $yesterday = Carbon::yesterday();

        $revenueToday = (float) DB::table('orders')
            ->whereDate('created_at', $today)
            ->where('status', 'completed')
            ->sum('total_amount');

        $revenueYesterday = (float) DB::table('orders')
            ->whereDate('created_at', $yesterday)
            ->where('status', 'completed')
            ->sum('total_amount');

        $startWeek = Carbon::now()->startOfWeek();
        $endWeek = Carbon::now()->endOfWeek();
        $startWeekLast = (clone $startWeek)->subWeek();
        $endWeekLast = (clone $endWeek)->subWeek();

        $weekThis = (float) DB::table('orders')
            ->whereBetween('created_at', [$startWeek, $endWeek])
            ->where('status', 'completed')
            ->sum('total_amount');

        $weekLast = (float) DB::table('orders')
            ->whereBetween('created_at', [$startWeekLast, $endWeekLast])
            ->where('status', 'completed')
            ->sum('total_amount');

        // month comparison
        $startMonth = Carbon::now()->startOfMonth();
        $endMonth = Carbon::now()->endOfMonth();
        $startMonthLast = (clone $startMonth)->subMonth();
        $endMonthLast = (clone $endMonth)->subMonth();

        $monthThis = (float) DB::table('orders')
            ->whereBetween('created_at', [$startMonth, $endMonth])
            ->where('status', 'completed')
            ->sum('total_amount');

        $monthLast = (float) DB::table('orders')
            ->whereBetween('created_at', [$startMonthLast, $endMonthLast])
            ->where('status', 'completed')
            ->sum('total_amount');

        // Category share (same as before)
        $categoryShare = DB::table('menu_categories')
            ->leftJoin('menu_items', 'menu_categories.id', '=', 'menu_items.category_id')
            ->leftJoin('order_items', 'menu_items.id', '=', 'order_items.menu_item_id')
            ->leftJoin('orders', 'order_items.order_id', '=', 'orders.id')
            ->select('menu_categories.name as category', DB::raw('SUM(order_items.quantity) as total_sold'))
            ->whereBetween('orders.created_at', [$from, $to])
            ->where('orders.status', 'completed')
            ->groupBy('menu_categories.id','menu_categories.name')
            ->get();

        // Top 5 products (sold) - keep existing shape (img/revenue/vat)
        $VAT_RATE = 0.1;
        $topProducts = DB::table('menu_items')
            ->join('menu_categories', 'menu_categories.id', '=', 'menu_items.category_id')
            ->join('order_items', 'menu_items.id', '=', 'order_items.menu_item_id')
            ->join('orders', 'orders.id', '=', 'order_items.order_id')
            ->leftJoin('menu_item_images', function($join){
                $join->on('menu_item_images.menu_item_id', '=', 'menu_items.id')
                     ->where('menu_item_images.is_featured', true);
            })
            ->select(
                'menu_items.id',
                'menu_items.name',
                'menu_categories.name as category',
                'menu_item_images.image_path as img',
                DB::raw('SUM(order_items.quantity) as sold'),
                DB::raw('SUM(order_items.quantity * menu_items.price) as revenue'),
                DB::raw('SUM(order_items.quantity * menu_items.price) * '.$VAT_RATE.' as vat')
            )
            ->whereBetween('orders.created_at', [$from, $to])
            ->where('orders.status', 'completed')
            ->groupBy('menu_items.id','menu_items.name','menu_categories.name','menu_item_images.image_path')
            ->orderByDesc('sold')
            ->limit(5)
            ->get();

        // Top 5 products by revenue
        $topProductsRevenue = DB::table('menu_items')
            ->join('order_items', 'menu_items.id', '=', 'order_items.menu_item_id')
            ->join('orders', 'orders.id', '=', 'order_items.order_id')
            ->select('menu_items.name', DB::raw('SUM(order_items.quantity * order_items.unit_price) as revenue'))
            ->where('orders.status', 'completed')
            ->whereBetween('orders.created_at', [$from, $to])
            ->groupBy('menu_items.name')
            ->orderByDesc('revenue')
            ->limit(5)
            ->get();
        // ===== DOANH THU 12 THÁNG =====
        $monthlyRevenue = [];

        for ($m = 1; $m <= 12; $m++) {
            $start = Carbon::create(now()->year, $m, 1)->startOfMonth();
            $end   = Carbon::create(now()->year, $m, 1)->endOfMonth();

            $monthlyRevenue[] = (float) DB::table('orders')
                ->whereBetween('created_at', [$start, $end])
                ->where('status', 'completed')
                ->sum('total_amount');
        }


        // Top customers
        $topCustomers = DB::table('users')
            ->join('orders', 'users.id', '=', 'orders.user_id')
            ->select(
                'users.id',
                'users.name',
                DB::raw('COUNT(orders.id) as orders_count'),
                DB::raw('SUM(orders.total_amount) as total_spent')
            )
            ->where('orders.status', 'completed')
            ->whereBetween('orders.created_at', [$from, $to])
            ->groupBy('users.id','users.name')
            ->orderByDesc('total_spent')
            ->limit(5)
            ->get();

        return view('admin.statistic.index', compact(
            'from','to',
            'totalRevenue','totalOrders','totalItems','cancelRate',
            // series and labels
            'labels7','data7','prev7',
            'labels8w','data8w','prev8w',
            'labels12','data12','prev12',
            // quick compares
            'revenueToday','revenueYesterday','weekThis','weekLast','monthThis','monthLast',
            'categoryShare','topProducts','topProductsRevenue','topCustomers','monthlyRevenue'
        ));
    }

    /**
     * Xuất PDF (giữ như cũ)
     */
    public function exportPdf(Request $request)
    {
        if ($request->filled('from') && $request->filled('to')) {
            if (Carbon::parse($request->from)->gt(Carbon::parse($request->to))) {
                return redirect()->back()->with('error', 'Không thể xuất PDF: ngày bắt đầu lớn hơn ngày kết thúc');
            }
        }

        $from = $request->from ? Carbon::parse($request->from)->startOfDay() : Carbon::now()->startOfMonth();
        $to   = $request->to   ? Carbon::parse($request->to)->endOfDay()   : Carbon::now()->endOfDay();

        $totalRevenue = DB::table('orders')
            ->whereBetween('created_at', [$from, $to])
            ->where('status', 'completed')
            ->sum('total_amount');

        $totalOrders = DB::table('orders')
            ->whereBetween('created_at', [$from, $to])
            ->where('status', 'completed')
            ->count();

        $totalItems = DB::table('order_items')
            ->join('orders', 'orders.id', '=', 'order_items.order_id')
            ->whereBetween('orders.created_at', [$from, $to])
            ->where('orders.status', 'completed')
            ->sum('order_items.quantity');

        $orders = DB::table('orders')
            ->whereBetween('created_at', [$from, $to])
            ->where('status', 'completed')
            ->orderBy('created_at')
            ->get();

        $pdf = Pdf::loadView('admin.statistic.pdf', compact(
            'from','to','totalRevenue','totalOrders','totalItems','orders'
        ))->setPaper('A4', 'portrait');

        return $pdf->download('bao-cao-thong-ke-' . now()->format('d-m-Y') . '.pdf');
    }
}

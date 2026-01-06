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

        // Default range: last 7 days if not provided
        $from = $request->from ? Carbon::parse($request->from)->startOfDay() : Carbon::now()->startOfDay()->subDays(6);
        $to   = $request->to   ? Carbon::parse($request->to)->endOfDay()   : Carbon::now()->endOfDay();

        // KPIs (giữ như cũ)
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

        // Determine period length and granularity
        $periodLengthDays = $from->diffInDays($to) + 1;

        // Range override from UI (toggle buttons should send ?range=7|8w|12m)
        $range = $request->get('range');

        if ($range === '7') {
            $granularity = 'day';
        } elseif ($range === '8w') {
            $granularity = 'week';
        } elseif ($range === '12m') {
            $granularity = 'month';
        } else {
            // fallback automatic
            if ($periodLengthDays <= 31) {
                $granularity = 'day';
            } elseif ($periodLengthDays <= 180) {
                $granularity = 'week';
            } else {
                $granularity = 'month';
            }
        }

        // Current period
        $currentPeriodStart = $from->copy();
        $currentPeriodEnd   = $to->copy();

        // Compute previous period aligned to granularity
        if ($granularity === 'day') {
            $days = $currentPeriodStart->diffInDays($currentPeriodEnd) + 1;
            $prevPeriodEnd = $currentPeriodStart->copy()->subDay();
            $prevPeriodStart = $prevPeriodEnd->copy()->subDays($days - 1);
        } elseif ($granularity === 'week') {
            // Align to week boundaries
            $currentWeekStart = $currentPeriodStart->copy()->startOfWeek();
            $currentWeekEnd = $currentPeriodEnd->copy()->endOfWeek();
            $weeks = $currentWeekStart->diffInWeeks($currentWeekEnd) + 1;

            // previous period = the weeks immediately before currentWeekStart, same number of weeks
            $prevPeriodEnd = $currentWeekStart->copy()->subWeek()->endOfWeek();
            $prevPeriodStart = $prevPeriodEnd->copy()->subWeeks($weeks - 1)->startOfWeek();

            // Also use week-aligned cursors for iteration below
            $currentPeriodStart = $currentWeekStart;
            $currentPeriodEnd = $currentWeekEnd;
        } else { // month
            $currentMonthStart = $currentPeriodStart->copy()->startOfMonth();
            $currentMonthEnd = $currentPeriodEnd->copy()->endOfMonth();
            $months = $currentMonthStart->diffInMonths($currentMonthEnd) + 1;

            $prevPeriodEnd = $currentMonthStart->copy()->subMonth()->endOfMonth();
            $prevPeriodStart = $prevPeriodEnd->copy()->subMonths($months - 1)->startOfMonth();

            // align for iteration
            $currentPeriodStart = $currentMonthStart;
            $currentPeriodEnd = $currentMonthEnd;
        }

        // Prepare SQL grouping and PHP key/label generators
        if ($granularity === 'day') {
            $groupSql = "DATE(created_at)";
            $makeKey = function (Carbon $d) { return $d->toDateString(); };
            $makeLabel = function (Carbon $d) { return $d->format('d/m'); };
            $cursorStart = $currentPeriodStart->copy();
            $cursorEnd = $currentPeriodEnd->copy();
            $cursorPrevStart = $prevPeriodStart->copy();
            $cursorPrevEnd = $prevPeriodEnd->copy();
            $advance = function (&$d) { $d->addDay(); };
            $advancePrev = function (&$d) { $d->addDay(); };
        } elseif ($granularity === 'week') {
            // Use ISO year-week key consistent with DATE_FORMAT %x (ISO year) and %v (ISO week)
            $groupSql = "CONCAT(DATE_FORMAT(created_at, '%x'), '-', LPAD(DATE_FORMAT(created_at, '%v'),2,'0'))";
            $makeKey = function (Carbon $d) {
                $s = $d->copy()->startOfWeek();
                return $s->format('o') . '-' . str_pad($s->format('W'), 2, '0', STR_PAD_LEFT);
            };
            $makeLabel = function (Carbon $d) { return $d->copy()->startOfWeek()->format('d/m'); };
            $cursorStart = $currentPeriodStart->copy()->startOfWeek();
            $cursorEnd = $currentPeriodEnd->copy()->endOfWeek();
            $cursorPrevStart = $prevPeriodStart->copy()->startOfWeek();
            $cursorPrevEnd = $prevPeriodEnd->copy()->endOfWeek();
            $advance = function (&$d) { $d->addWeek(); };
            $advancePrev = function (&$d) { $d->addWeek(); };
        } else {
            // month
            $groupSql = "DATE_FORMAT(created_at, '%Y-%m')";
            $makeKey = function (Carbon $d) { return $d->format('Y-m'); };
            $makeLabel = function (Carbon $d) { return $d->format('M Y'); };
            $cursorStart = $currentPeriodStart->copy()->startOfMonth();
            $cursorEnd = $currentPeriodEnd->copy()->endOfMonth();
            $cursorPrevStart = $prevPeriodStart->copy()->startOfMonth();
            $cursorPrevEnd = $prevPeriodEnd->copy()->endOfMonth();
            $advance = function (&$d) { $d->addMonth(); };
            $advancePrev = function (&$d) { $d->addMonth(); };
        }

        // Query aggregated sums for current period
        $currentRows = DB::table('orders')
            ->select(DB::raw("$groupSql as period_key"), DB::raw('SUM(total_amount) as total'))
            ->whereBetween('created_at', [$cursorStart->copy()->startOfDay(), $cursorEnd->copy()->endOfDay()])
            ->where('status', 'completed')
            ->groupBy('period_key')
            ->orderBy('period_key')
            ->get()
            ->pluck('total', 'period_key')
            ->toArray();

        // Query aggregated sums for previous period
        $prevRows = DB::table('orders')
            ->select(DB::raw("$groupSql as period_key"), DB::raw('SUM(total_amount) as total'))
            ->whereBetween('created_at', [$cursorPrevStart->copy()->startOfDay(), $cursorPrevEnd->copy()->endOfDay()])
            ->where('status', 'completed')
            ->groupBy('period_key')
            ->orderBy('period_key')
            ->get()
            ->pluck('total', 'period_key')
            ->toArray();

        // Build labels and aligned arrays for current period
        $chartLabels = [];
        $chartCurrent = [];

        $cursor = $cursorStart->copy();
        while ($cursor->lte($cursorEnd)) {
            $key = $makeKey($cursor->copy());
            $label = $makeLabel($cursor->copy());
            $chartLabels[] = $label;
            $chartCurrent[] = (float) ($currentRows[$key] ?? 0.0);

            // advance cursor depending on granularity
            $advance($cursor);
        }

        // Build previous period array
        $prevTemp = [];
        $cursorP = $cursorPrevStart->copy();
        while ($cursorP->lte($cursorPrevEnd)) {
            $keyP = $makeKey($cursorP->copy());
            $prevTemp[] = (float) ($prevRows[$keyP] ?? 0.0);
            $advancePrev($cursorP);
        }

        // Align lengths: pad front with zeros if prev shorter, slice if longer
        $len = count($chartLabels);
        if (count($prevTemp) < $len) {
            $pad = array_fill(0, $len - count($prevTemp), 0.0);
            $chartPrevious = array_merge($pad, $prevTemp);
        } else {
            $chartPrevious = array_slice($prevTemp, -$len);
        }
        if (empty($chartPrevious)) {
            $chartPrevious = array_fill(0, $len, 0.0);
        }

        // QUICK COMPARISONS: today / yesterday / week / month (unchanged)
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

        // Category share
        $categoryShare = DB::table('menu_categories')
            ->leftJoin('menu_items', 'menu_categories.id', '=', 'menu_items.category_id')
            ->leftJoin('order_items', 'menu_items.id', '=', 'order_items.menu_item_id')
            ->leftJoin('orders', 'order_items.order_id', '=', 'orders.id')
            ->select('menu_categories.name as category', DB::raw('SUM(order_items.quantity) as total_sold'))
            ->whereBetween('orders.created_at', [$from, $to])
            ->where('orders.status', 'completed')
            ->groupBy('menu_categories.id','menu_categories.name')
            ->get();

        // Top products (sold)
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

        // Top products by revenue
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

        // Monthly revenue - giữ như cũ (12 tháng hiện tại)
        $monthlyRevenue = [];
        for ($m = 1; $m <= 12; $m++) {
            $startMonthLoop = Carbon::create(now()->year, $m, 1)->startOfMonth();
            $endMonthLoop   = Carbon::create(now()->year, $m, 1)->endOfMonth();
            $monthlyRevenue[] = (float) DB::table('orders')
                ->whereBetween('created_at', [$startMonthLoop, $endMonthLoop])
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

        // Return view with unified chart arrays + granularity
        return view('admin.statistic.index', compact(
            'from','to',
            'totalRevenue','totalOrders','totalItems','cancelRate',
            'chartLabels','chartCurrent','chartPrevious','granularity',
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

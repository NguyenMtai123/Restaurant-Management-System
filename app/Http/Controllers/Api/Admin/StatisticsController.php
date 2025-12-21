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
        // Validate ngày
        if ($request->filled('from') && $request->filled('to')) {
            if (Carbon::parse($request->from)->gt(Carbon::parse($request->to))) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->with('error', 'Ngày bắt đầu phải nhỏ hơn hoặc bằng ngày kết thúc');
            }
        }
        // Lọc theo khoảng thời gian
        $from = $request->from ? Carbon::parse($request->from)->startOfDay() : Carbon::now()->startOfMonth();
        $to   = $request->to ? Carbon::parse($request->to)->endOfDay() : Carbon::now()->endOfDay();

        // 1. Tổng doanh thu từ đơn hàng đã hoàn thành
        $totalRevenue = DB::table('orders')
            ->whereBetween('created_at', [$from, $to])
            ->where('status', 'completed')
            ->sum('total_amount');

        // 2. Tổng đơn hàng đã hoàn thành
        $totalOrders = DB::table('orders')
            ->whereBetween('created_at', [$from, $to])
            ->where('status', 'completed')
            ->count();

        // 3. Tổng sản phẩm đã bán (trong đơn hoàn thành)
        $totalItems = DB::table('order_items')
            ->join('orders', 'orders.id', '=', 'order_items.order_id')
            ->whereBetween('orders.created_at', [$from, $to])
            ->where('orders.status', 'completed')
            ->sum('order_items.quantity');

        // 4. Tỉ lệ hủy đơn (%)
        $cancelOrders = DB::table('orders')
            ->whereBetween('created_at', [$from, $to])
            ->where('status', 'cancelled')
            ->count();

        $cancelRate = ($cancelOrders + $totalOrders) > 0
            ? round($cancelOrders / ($cancelOrders + $totalOrders) * 100, 2)
            : 0;

        // 5. Biểu đồ doanh thu theo tháng (12 tháng gần nhất)
        $monthlyRevenue = DB::table('orders')
            ->select(DB::raw('MONTH(created_at) as month'), DB::raw('SUM(total_amount) as revenue'))
            ->whereBetween('created_at', [Carbon::now()->subMonths(11)->startOfMonth(), Carbon::now()->endOfMonth()])
            ->where('status', 'completed')
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->orderBy('month')
            ->pluck('revenue','month'); // ['1'=>value, '2'=>value,...]

        // 6. Tỷ lệ bán theo danh mục (trong đơn hoàn thành)
        $categoryShare = DB::table('menu_categories')
            ->leftJoin('menu_items', 'menu_categories.id', '=', 'menu_items.category_id')
            ->leftJoin('order_items', 'menu_items.id', '=', 'order_items.menu_item_id')
            ->leftJoin('orders', 'order_items.order_id', '=', 'orders.id')
            ->select('menu_categories.name as category', DB::raw('SUM(order_items.quantity) as total_sold'))
            ->whereBetween('orders.created_at', [$from, $to])
            ->where('orders.status', 'completed')
            ->groupBy('menu_categories.id','menu_categories.name')
            ->get();

        // 7. Top 5 sản phẩm bán chạy nhất (trong đơn hoàn thành)
        $VAT_RATE = 0.1; // 10%
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

        return view('admin.statistic.index', compact(
            'totalRevenue',
            'totalOrders',
            'totalItems',
            'cancelRate',
            'monthlyRevenue',
            'categoryShare',
            'topProducts',
            'from',
            'to'
        ));
    }

    public function exportPdf(Request $request)
    {
        if ($request->filled('from') && $request->filled('to')) {
            if (Carbon::parse($request->from)->gt(Carbon::parse($request->to))) {
                return redirect()
                    ->back()
                    ->with('error', 'Không thể xuất PDF: ngày bắt đầu lớn hơn ngày kết thúc');
            }
        }
        $from = $request->from
            ? Carbon::parse($request->from)->startOfDay()
            : Carbon::now()->startOfMonth();

        $to = $request->to
            ? Carbon::parse($request->to)->endOfDay()
            : Carbon::now()->endOfDay();

        // Tổng doanh thu
        $totalRevenue = DB::table('orders')
            ->whereBetween('created_at', [$from, $to])
            ->where('status', 'completed')
            ->sum('total_amount');

        // Tổng đơn
        $totalOrders = DB::table('orders')
            ->whereBetween('created_at', [$from, $to])
            ->where('status', 'completed')
            ->count();

        // Tổng sản phẩm bán
        $totalItems = DB::table('order_items')
            ->join('orders', 'orders.id', '=', 'order_items.order_id')
            ->whereBetween('orders.created_at', [$from, $to])
            ->where('orders.status', 'completed')
            ->sum('order_items.quantity');

        // Danh sách đơn hàng
        $orders = DB::table('orders')
            ->whereBetween('created_at', [$from, $to])
            ->where('status', 'completed')
            ->orderBy('created_at')
            ->get();

        $pdf = Pdf::loadView('admin.statistic.pdf', compact(
            'from',
            'to',
            'totalRevenue',
            'totalOrders',
            'totalItems',
            'orders'
        ))->setPaper('A4', 'portrait');

        return $pdf->download(
            'bao-cao-thong-ke-' . now()->format('d-m-Y') . '.pdf'
        );
    }

}

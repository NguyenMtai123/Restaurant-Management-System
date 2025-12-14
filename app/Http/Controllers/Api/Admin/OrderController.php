<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
     // Hiển thị danh sách hóa đơn
    public function index()
    {
        $orders = Order::with('user', 'orderItems.menuItem')->latest()->get();
        return view('admin.orders.index', compact('orders'));
    }

    // Xem chi tiết hóa đơn
    public function show(Order $order)
    {
         $order->load('user', 'orderItems.menuItem');
         return view('admin.orders.show', compact('order'));
    }

    // Cập nhật trạng thái hóa đơn
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,delivered,completed,cancelled',
        ]);

        $order->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Cập nhật trạng thái thành công!');
    }

    // Hủy hóa đơn
    public function cancel(Order $order)
    {
        $order->update(['status' => 'cancelled']);
        return redirect()->back()->with('success', 'Hóa đơn đã được hủy!');
    }
}

<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;

class HisOrderController extends Controller
{
    public function history()
    {
        $user = Auth::user();
        $orders = $user->orders()->orderBy('created_at', 'desc')->paginate(5);
        return view('customer.orders.history', compact('orders'));
    }

    public function show(Order $order)
    {
        $user = Auth::user();
        if ($order->user_id !== $user->id) {
            abort(403);
        }

        $order->load('orderItems.menuItem', 'payments');

        return view('customer.orders.detail', compact('order'));
    }

    public function cancel(Order $order)
    {
        $user = Auth::user();

        // 1. Không cho hủy đơn của người khác
        if ($order->user_id !== $user->id) {
            abort(403);
        }

        // 2. Chỉ cho hủy khi pending
        if ($order->status !== 'pending') {
            return back()->with('error', 'Đơn hàng không thể hủy ở trạng thái hiện tại.');
        }

        // 3. Kiểm tra thanh toán
        $paidPayment = $order->payments()
            ->where('status', 'paid')
            ->exists();

        if ($paidPayment) {
            return back()->with('error', 'Đơn hàng đã thanh toán, không thể hủy.');
        }

        // 4. Hủy đơn
        $order->update([
            'status' => 'cancelled'
        ]);

        // 5. Nếu có payment pending → hủy luôn
        $order->payments()->update([
            'status' => 'cancelled'
        ]);

        return back()->with('success', 'Hủy đơn hàng thành công.');
    }

    public function confirmReceived(Order $order)
    {
        $user = Auth::user();

        // Không cho thao tác đơn của người khác
        if ($order->user_id !== $user->id) {
            abort(403);
        }

        // Chỉ xác nhận khi đang giao
        if ($order->status !== 'delivered') {
            return back()->with('error', 'Đơn hàng chưa thể xác nhận.');
        }

        // Cập nhật trạng thái
        $order->update([
            'status' => 'completed'
        ]);

        return back()->with('success', 'Xác nhận đã nhận hàng thành công!');
    }

}

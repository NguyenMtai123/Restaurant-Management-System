<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function showPaymentForm($orderId)
    {
        $order = Order::findOrFail($orderId);
        return view('customer.payments.form', compact('order'));
    }

    public function pay(Request $request, $orderId)
    {
        $user = auth()->user();
        if (! $user) {
            return response()->json(['error' => 'Bạn cần đăng nhập'], 401);
        }

        $order = Order::findOrFail($orderId);

        if ($order->status !== 'pending') {
            return response()->json(['error' => 'Đơn hàng không thể thanh toán'], 400);
        }
        $payment = Payment::create([
            'order_id' => $order->id,
            'method' => $request->input('method', 'cash'),
            'amount' => $order->total_amount,
            'status' => 'paid',
        ]);

        // Cập nhật trạng thái đơn
        $order->update(['status' => 'completed']);

        return response()->json([
            'success' => true,
            'message' => 'Thanh toán thành công!',
            'payment' => $payment
        ]);
    }
}

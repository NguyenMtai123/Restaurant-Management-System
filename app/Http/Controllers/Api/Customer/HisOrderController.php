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

    // Trả view partial cho modal
     public function show(Order $order)
    {
        $user = Auth::user();
        if ($order->user_id !== $user->id) {
            abort(403);
        }

        $order->load('orderItems.menuItem', 'payments');

        return view('customer.orders.detail', compact('order'));
    }

}

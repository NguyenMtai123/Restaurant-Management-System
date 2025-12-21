<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
public function store(Request $request)
{
    $user = auth()->user();
    if (!$user) {
        return response()->json([
            'success' => false,
            'error' => 'Bạn cần đăng nhập để đặt hàng'
        ], 401);
    }

    $cart = Cart::where('user_id', $user->id)
        ->with('items.menuItem')
        ->first();

    if (!$cart || $cart->items->isEmpty()) {
        return response()->json([
            'success' => false,
            'error' => 'Giỏ hàng của bạn đang trống'
        ], 400);
    }

    $subtotal = $cart->items->sum(fn($i) => $i->quantity * $i->menuItem->price);
    $tax = $subtotal * 0.1;
    $total = $subtotal + $tax;

    $order = Order::create([
        'order_number' => 'ORD-' . time(),
        'user_id' => $user->id,
        'subtotal' => $subtotal,
        'tax' => $tax,
        'total_amount' => $total,
        'status' => 'pending',
    ]);

    foreach ($cart->items as $item) {
        OrderItem::create([
            'order_id' => $order->id,
            'menu_item_id' => $item->menuItem->id,
            'quantity' => $item->quantity,
            'unit_price' => $item->menuItem->price,
        ]);
    }

    $cart->items()->delete();

    return response()->json([
        'success' => true,
        'message' => 'Đặt hàng thành công!',
        'order' => [
            'id' => $order->id,
            'order_number' => $order->order_number,
            'total_amount' => $total
        ]
    ]);
}

    public function show($id)
    {
        $user = auth()->user();
        if (! $user) {
            return redirect()->route('login')->with('error', 'Bạn cần đăng nhập');
        }

        // Load order cùng orderItems, menuItem và payments
        $order = Order::with(['orderItems.menuItem', 'payments'])
        ->where('id', $id)
        ->where('user_id', $user->id)
        ->firstOrFail();


        return view('customer.orders.show', compact('order'));
    }




}

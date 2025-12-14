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
        if (! $user) {
            return response()->json(['error' => 'Bạn cần đăng nhập'], 401);
        }

        $cart = Cart::where('user_id', $user->id)->with('items.menuItem')->first();

        if (! $cart || $cart->items->isEmpty()) {
            return response()->json(['error' => 'Giỏ hàng trống'], 400);
        }

        // Tính tiền
        $subtotal = $cart->items->sum(fn ($i) => $i->quantity * $i->menuItem->price);
        $tax = $subtotal * 0.1;
        $total = $subtotal + $tax;

        // Tạo order
        $order = Order::create([
            'order_number' => 'ORD-'.time(),
            'user_id' => $user->id,
            'subtotal' => $subtotal,
            'tax' => $tax,
            'total_amount' => $total,
            'status' => 'pending',
            'notes' => null,
        ]);

        // Tạo item
        foreach ($cart->items as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'menu_item_id' => $item->menuItem->id,
                'quantity' => $item->quantity,
                'unit_price' => $item->menuItem->price,
            ]);
        }

        // Xóa giỏ hàng
        $cart->items()->delete();

       return response()->json([
            'success' => true,
            'message' => 'Đặt hàng thành công!',
            'order' => [
                'id' => $order->id,
                'order_number' => $order->order_number,
                'total_amount' => $total,
                'status' => $order->status,
            ]
        ]);

    }
   public function show($id)
    {
        $user = auth()->user();
        if (! $user) {
            return redirect()->route('login')->with('error', 'Bạn cần đăng nhập');
        }

        // Load order cùng orderItems và menuItem để tránh N+1
        $order = Order::with('orderItems.menuItem')
            ->where('id', $id)
            ->where('user_id', $user->id)
            ->firstOrFail();

        return view('customer.orders.show', compact('order'));
    }



}

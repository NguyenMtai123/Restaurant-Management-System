<?php

namespace App\Http\Controllers\Api\Customer;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\MenuItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
     // Lấy giỏ hàng hiện tại
    public function index()
    {
        $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);
        $cart->load('items.menuItem.images');
            return response()->json($cart);
    }

    public function add(Request $request)
{
    if (!Auth::check()) {
        return response()->json([
            'success' => false,
            'need_login' => true,
            'message' => 'Bạn cần đăng nhập để thêm món vào giỏ hàng'
        ], 401);
    }

    $request->validate([
        'item_id' => 'required|exists:menu_items,id',
        'quantity' => 'nullable|integer|min:1'
    ]);

    $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);

    $cartItem = CartItem::firstOrNew([
        'cart_id' => $cart->id,
        'item_id' => $request->item_id
    ]);

    $cartItem->quantity = $cartItem->exists
        ? $cartItem->quantity + ($request->quantity ?? 1)
        : ($request->quantity ?? 1);

    $cartItem->save();

    $cart->load('items.menuItem.images');

    return response()->json([
        'success' => true,
        'cart' => $cart
    ]);
}


    public function remove(Request $request)
    {
        $request->validate(['item_id' => 'required|exists:menu_items,id']);
        $cart = Cart::where('user_id', Auth::id())->first();
        if ($cart) {
            CartItem::where('cart_id', $cart->id)
                ->where('item_id', $request->item_id)
                ->delete();
        }
         $cart->load('items.menuItem.images');
        return response()->json($cart);
    }

    public function update(Request $request)
    {
        $request->validate([
            'item_id' => 'required|exists:menu_items,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $cart = Cart::where('user_id', Auth::id())->first();
        if ($cart) {
            $item = $cart->items()->where('item_id', $request->item_id)->first();
            if ($item) {
                $item->quantity = $request->quantity;
                $item->save();
            }
        }

         $cart->load('items.menuItem.images');
        return response()->json($cart);
    }
}

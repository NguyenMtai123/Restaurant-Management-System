<?php

namespace App\Http\Controllers\Api\Customer;

use Exception;
use Carbon\Carbon;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Coupon;
use App\Models\OrderItem;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

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

        $cart = Cart::where('user_id', $user->id)->with('items.menuItem')->first();
        if (!$cart || $cart->items->isEmpty()) {
            return response()->json(['success' => false, 'error' => 'Giỏ hàng của bạn đang trống'], 400);
        }

        // Kiểm tra menuItem tồn tại để tránh lỗi undefined
        foreach ($cart->items as $item) {
            if (! $item->menuItem) {
                return response()->json(['success' => false, 'error' => "Sản phẩm trong giỏ không tồn tại (id: {$item->menu_item_id})"], 400);
            }
        }
        $subtotal = $cart->items->sum(fn($i) => $i->quantity * $i->menuItem->price);

        // Lấy coupon từ session (nếu có)
        $couponData = session('coupon', []);
        $discount = $couponData['discount'] ?? 0;
        $shippingDiscount = $couponData['shipping_discount'] ?? 0;
        $couponId = $couponData['coupon_id'] ?? null;
        $appliedCoupon = null;

        if (!empty($couponData['code'])) {
            $code = strtoupper($couponData['code']);

            if ($code === 'BUY1GET20') {
                if ($subtotal < 1000000) {
                    return response()->json([
                        'success' => false,
                        'error' => 'Mã BUY1GET20 chỉ áp dụng cho đơn hàng từ 1.000.000đ'
                    ], 400);
                }
                $usedBigOrder = Order::where('user_id', $user->id)
                    ->where('subtotal', '>=', 1000000)
                    ->exists();

                if ($usedBigOrder) {
                    return response()->json([
                        'success' => false,
                        'error' => 'Mã BUY1GET20 chỉ áp dụng cho đơn đầu tiên trên 1.000.000đ'
                    ], 400);
                }

                $discount = round($subtotal * 0.2, 2);
            }

            if ($code === 'FREESHIP') {
                if ($subtotal >= 200000) {
                    $shippingDiscount = 1;
                }
            }

        }


        // Nếu có couponId (coupon trong DB) -> validate lại trước khi checkout
        if ($couponId) {
            $coupon = Coupon::find($couponId);
            if (! $coupon) {
                return response()->json(['success' => false, 'error' => 'Mã giảm giá không tồn tại'], 400);
            }

            $now = Carbon::now();

            if (! $coupon->is_active || $coupon->start_date > $now || $coupon->end_date < $now) {
                return response()->json(['success' => false, 'error' => 'Mã giảm giá chưa có hiệu lực hoặc đã hết hạn'], 400);
            }

            if ($coupon->max_uses && $coupon->used >= $coupon->max_uses) {
                return response()->json(['success' => false, 'error' => 'Mã giảm giá đã hết lượt sử dụng'], 400);
            }

            // kiểm tra user đã dùng chưa (chỉ tính is_used = 1)
            $usedByUser = DB::table('coupon_user')
                ->where('coupon_id', $coupon->id)
                ->where('user_id', $user->id)
                ->where('is_used', 1)
                ->exists();

            if ($usedByUser) {
                return response()->json(['success' => false, 'error' => 'Bạn đã sử dụng mã này rồi'], 400);
            }

            // kiểm tra min_order
            if ($coupon->min_order && $subtotal < $coupon->min_order) {
                return response()->json(['success' => false, 'error' => 'Đơn hàng chưa đạt giá trị tối thiểu để dùng mã'], 400);
            }

            // recalc discount từ coupon DB (bảo đảm đúng)
            $discount = $coupon->type === 'percent'
                ? round($subtotal * ($coupon->value / 100), 2)
                : min($coupon->value, $subtotal);

            // nếu coupon định nghĩa freeship bằng giá trị đặc biệt, bạn có thể set shippingDiscount = 1;
            // (ở đây giả sử coupon không có flag freeship, nếu có field thì xử lý thêm)
            $appliedCoupon = $coupon;
        }

        // Tính VAT 10% và phí vận chuyển
        $tax = round($subtotal * 0.1, 2);
        $shipping = $shippingDiscount ? 0 : $tax;

        // Tổng tiền (không âm)
        $total = $subtotal + $shipping - $discount;
        if ($total < 0) $total = 0;

        // Bắt đầu transaction
        DB::beginTransaction();
        try {
            // Tạo order_number tránh trùng
            $orderNumber = 'ORD-' . strtoupper(Str::random(8));

            $order = Order::create([
                'order_number'   => $orderNumber,
                'user_id'        => $user->id,
                'subtotal'       => $subtotal,
                'tax'            => $shipping,
                'discount_amount'=> $discount,
                'total_amount'   => $total,
                'coupon_id'      => $couponId,
                'status'         => 'pending',
            ]);

            // Tạo order items
            foreach ($cart->items as $item) {
                OrderItem::create([
                    'order_id'     => $order->id,
                    'menu_item_id' => $item->menuItem->id,
                    'quantity'     => $item->quantity,
                    'unit_price'   => $item->menuItem->price,
                ]);
            }

            // Cập nhật coupon (nếu có coupon DB)
            if ($appliedCoupon) {
                // Tăng số lượt used
                $appliedCoupon->increment('used');

                // Nếu đã có bản ghi coupon_user trước đó -> update, nếu chưa -> insert
                $exists = DB::table('coupon_user')
                    ->where('coupon_id', $appliedCoupon->id)
                    ->where('user_id', $user->id)
                    ->exists();

                if ($exists) {
                    DB::table('coupon_user')
                        ->where('coupon_id', $appliedCoupon->id)
                        ->where('user_id', $user->id)
                        ->update([
                            'is_used'    => true,
                            'used_at'    => Carbon::now(),
                            'updated_at' => Carbon::now()
                        ]);
                } else {
                    DB::table('coupon_user')->insert([
                        'coupon_id'  => $appliedCoupon->id,
                        'user_id'    => $user->id,
                        'is_used'    => true,
                        'sent_at'    => null,
                        'used_at'    => Carbon::now(),
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);
                }
            }

            // Xóa items giỏ hàng
            $cart->items()->delete();

            // Xóa session coupon
            session()->forget('coupon');

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Đặt hàng thành công!',
                'order' => [
                    'id' => $order->id,
                    'order_number' => $order->order_number,
                    'subtotal' => $subtotal,
                    'discount' => $discount,
                    'shipping_fee' => $shipping,
                    'total_amount' => $total,
                ]
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            // bạn có thể log $e->getMessage() để debug
            return response()->json([
                'success' => false,
                'error' => 'Đặt hàng thất bại: ' . $e->getMessage()
            ], 500);
        }
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

    public function applyCoupon(Request $request)
    {
        $request->validate(['coupon_code'=>'required|string']);
        $user = auth()->user();
        if (!$user) return response()->json(['success'=>false,'error'=>'Bạn cần đăng nhập'], 401);

        $cart = Cart::where('user_id', $user->id)->with('items.menuItem')->first();
        if (!$cart || $cart->items->isEmpty()) return response()->json(['success'=>false,'error'=>'Giỏ hàng trống'], 400);

        $subtotal = $cart->items->sum(fn($i) => $i->quantity * $i->menuItem->price);
        $couponCode = strtoupper($request->coupon_code);

        $discount = 0;
        $shippingDiscount = 0;
        $valid = false;
        $message = '';

        switch($couponCode) {
            case 'WELCOME20':
                $firstOrder = Order::where('user_id', $user->id)->count() === 0;
                if ($firstOrder) {
                    $discount = $subtotal * 0.2;
                    $valid = true;
                    $message = 'Giảm 20% cho đơn hàng đầu tiên';
                } else {
                    $message = 'Mã WELCOME20 chỉ áp dụng cho đơn đầu tiên';
                }
                break;

            case 'BUY1GET20':
                if ($subtotal < 1000000) {
                    $message = 'Mã BUY1GET20 áp dụng cho đơn từ 1.000.000đ';
                    break;
                }

                $usedBigOrder = Order::where('user_id', $user->id)
                    ->where('subtotal', '>=', 1000000)
                    ->exists();

                if ($usedBigOrder) {
                    $message = 'Mã BUY1GET20 chỉ áp dụng cho đơn đầu tiên trên 1.000.000đ';
                    break;
                }

                $discount = $subtotal * 0.2;
                $valid = true;
                $message = 'Giảm 20% cho đơn đầu tiên trên 1.000.000đ';
                break;

            case 'FREESHIP':
                if ($subtotal >= 200000) {
                    $shippingDiscount = 1;
                    $valid = true;
                    $message = 'Miễn phí vận chuyển cho đơn từ 200.000đ';
                } else {
                    $message = 'Mã FREESHIP áp dụng cho đơn từ 200.000đ';
                }
                break;

            default:
                // --- Mã trong DB ---
                $coupon = Coupon::where('code', $couponCode)->first();
                if (!$coupon) {
                    $message = 'Mã giảm giá không tồn tại';
                    break;
                }

                if (!$coupon->is_active || $coupon->start_date > now() || $coupon->end_date < now()) {
                    $message = 'Mã giảm giá chưa có hiệu lực hoặc đã hết hạn';
                    break;
                }

                // kiểm tra số lượng sử dụng
                if ($coupon->max_uses && $coupon->used >= $coupon->max_uses) {
                    $message = 'Mã giảm giá đã hết lượt sử dụng';
                    break;
                }

                // kiểm tra người dùng đã dùng chưa
                $usedByUser = \DB::table('coupon_user')
                    ->where('coupon_id', $coupon->id)
                    ->where('user_id', $user->id)
                    ->where('is_used', 1)
                    ->exists();

                if ($usedByUser) {
                    $message = 'Bạn đã sử dụng mã này rồi';
                    break;
                }


                // kiểm tra đơn tối thiểu
                if ($coupon->min_order && $subtotal < $coupon->min_order) {
                    $message = 'Đơn hàng chưa đạt giá trị tối thiểu để dùng mã';
                    break;
                }

                // --- Áp dụng ---
                $discount = $coupon->type === 'percent'
                    ? $subtotal * ($coupon->value / 100)
                    : min($coupon->value, $subtotal);

                $valid = true;
                $message = 'Áp dụng mã giảm giá thành công';
                $couponId = $coupon->id;
        }

        if (!$valid) return response()->json(['success'=>false,'error'=>$message], 400);

        // lưu session
        session([
            'coupon' => [
                'code' => $couponCode,
                'discount' => $discount,
                'shipping_discount' => $shippingDiscount,
                'coupon_id' => $couponId ?? null
            ]
        ]);

        return response()->json([
            'success' => true,
            'message' => $message,
            'discount_amount' => $discount,
            'shipping_discount' => $shippingDiscount,
            'total_after_discount' => $subtotal - $discount
        ]);
    }

}

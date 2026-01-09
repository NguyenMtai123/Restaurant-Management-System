<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use App\Mail\OrderPaidMail;
use Illuminate\Support\Facades\Mail;

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
        if (!$user) return response()->json(['error' => 'Bạn cần đăng nhập'], 401);

        $order = Order::findOrFail($orderId);
        $paymentMethod = $request->input('method', 'cash');

        if ($paymentMethod === 'online') {
            // Online → redirect sang VNPay
            $vnpayUrl = route('vnpay_payment', ['order_id' => $order->id]);
            return response()->json([
                'success' => true,
                'redirect' => $vnpayUrl
            ]);
        }

        // Offline (cash, bank_transfer) → tạo Payment pending
        $payment = Payment::create([
            'order_id' => $order->id,
            'method' => $paymentMethod,
            'amount' => $order->total_amount,
            'status' => 'pending', // chờ xác nhận
        ]);

        $order->update(['status' => 'pending']);

        // Gửi email xác nhận đơn hàng
        Mail::to($order->user->email)->send(new OrderPaidMail($order));

        return response()->json([
            'success' => true,
            'message' => 'Thanh toán được ghi nhận, chờ xác nhận!',
            'payment' => $payment
        ]);
    }

    public function vnpay_payment(Request $request)
    {
        $orderId = $request->query('order_id');
        $order = Order::findOrFail($orderId);

        $vnp_TmnCode = "SBZ91UGR";
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_HashSecret = "LXF9ZK655RYARCK1QP9GMO6V2WMQYDSN";
        $vnp_Returnurl = route('vnpay.return');

        $vnp_TxnRef = $order->order_number;
        $vnp_Amount = $order->total_amount * 100;
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];

        $inputData = [
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => 'vn',
            "vnp_OrderInfo" => "Thanh toán đơn #{$order->order_number}",
            "vnp_OrderType" => 'billpayment',
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef
        ];

        ksort($inputData);

        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }

        // Redirect trực tiếp sang VNPay
        return redirect()->to($vnp_Url);
    }

    public function vnpay_return(Request $request)
{
    $vnp_ResponseCode = $request->query('vnp_ResponseCode');
    $orderNumber = $request->query('vnp_TxnRef');

    $order = Order::where('order_number', $orderNumber)->firstOrFail();

    if ($vnp_ResponseCode == '00') {
        Payment::create([
            'order_id' => $order->id,
            'method' => 'online',
            'amount' => $order->total_amount,
            'status' => 'paid',
        ]);

        $order->update(['status' => 'delivered']);
        Mail::to($order->user->email)->send(new OrderPaidMail($order));

        return redirect()->route('orders.show', $order->id)
                         ->with('success', 'Thanh toán VNPay thành công!');
    }

    return redirect()->route('orders.show', $order->id)
                     ->with('error', 'Thanh toán VNPay không thành công!');
}

}

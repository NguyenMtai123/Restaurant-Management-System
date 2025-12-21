<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xác nhận đơn hàng</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f5f5f5; margin:0; padding:0; }
        .email-container { max-width: 600px; margin: 30px auto; background-color: #fff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
        .email-header { background-color: #1a202c; color: #fff; padding: 20px; text-align: center; }
        .email-header h1 { margin: 0; font-size: 24px; }
        .email-body { padding: 20px; color: #333; }
        .email-body h2 { color: #1a202c; font-size: 20px; margin-bottom: 10px; }
        .order-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .order-table th, .order-table td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        .order-table th { background-color: #f0f0f0; }
        .order-total { font-weight: bold; }
        .customer-info { margin-bottom: 20px; }
        .btn { display: inline-block; padding: 12px 25px; background-color: #1a202c; color: #fff; text-decoration: none; border-radius: 5px; }
        .email-footer { text-align: center; padding: 20px; font-size: 14px; color: #777; }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <h1>{{ config('app.name') }}</h1>
        </div>
        <div class="email-body">
            <h2>Đơn hàng của bạn đã được xác nhận thành công!</h2>
            <p>Chi tiết đơn hàng:</p>

            <table class="order-table">
                <thead>
                    <tr>
                        <th>Sản phẩm</th>
                        <th>Số lượng</th>
                        <th>Giá</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->orderItems as $item)
                    <tr>
                        <td>{{ $item->menuItem->name }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ number_format($item->unit_price) }} đ</td>
                    </tr>
                    @endforeach
                    <tr>
                        <td colspan="2" class="order-total">Tổng cộng</td>
                        <td class="order-total">{{ number_format($order->total_amount) }} đ</td>
                    </tr>
                </tbody>
            </table>

            <div class="customer-info">
                <p><strong>Thông tin khách hàng:</strong></p>
                <p>Tên: {{ $order->user->name }}</p>
                <p>Email: {{ $order->user->email }}</p>
                <p>SĐT: {{ $order->user->phone ?? 'Chưa cập nhật' }}</p>
            </div>

            <a href="{{ route('orders.show', $order->id) }}" class="btn">Xem đơn hàng</a>
        </div>

        <div class="email-footer">
            <p>Cảm ơn bạn,</p>
            <p>{{ config('app.name') }}</p>
        </div>
    </div>
</body>
</html>

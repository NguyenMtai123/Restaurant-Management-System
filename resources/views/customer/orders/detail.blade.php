<div class="order-detail">
    <h3>Hóa đơn #{{ $order->order_number }}</h3>
    <p><strong>Ngày đặt:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
    <p><strong>Trạng thái:</strong> <span class="status {{ $order->status }}">{{ ucfirst($order->status) }}</span></p>

    <table>
        <thead>
            <tr>
                <th>Món</th>
                <th>SL</th>
                <th>Đơn giá</th>
                <th>Thành tiền</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->orderItems as $item)
                <tr>
                    <td>{{ $item->menuItem->name }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ number_format($item->unit_price,0,',','.') }} đ</td>
                    <td>{{ number_format($item->quantity * $item->unit_price,0,',','.') }} đ</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div style="text-align:right; margin-top:12px;">
        <p>Tạm tính: <strong>{{ number_format($order->subtotal,0,',','.') }} đ</strong></p>
        <p>Thuế: <strong>{{ number_format($order->tax,0,',','.') }} đ</strong></p>
        <p>Tổng: <strong>{{ number_format($order->total_amount,0,',','.') }} đ</strong></p>
    </div>
</div>

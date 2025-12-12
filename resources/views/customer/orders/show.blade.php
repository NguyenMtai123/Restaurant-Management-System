@extends('customer.layouts.app')

@section('title', 'Chi tiết đơn hàng')

@section('content')
    <h1>Chi tiết đơn hàng #{{ $order->order_number }}</h1>
    <p>Trạng thái: {{ ucfirst($order->status) }}</p>
    <p>Loại đơn: {{ ucfirst($order->order_type) }}</p>
    <p>Tạm tính: {{ number_format($order->subtotal, 0, ',', '.') }} đ</p>
    <p>Thuế: {{ number_format($order->tax, 0, ',', '.') }} đ</p>
    <p>Tổng: {{ number_format($order->total_amount, 0, ',', '.') }} đ</p>

    <h2>Danh sách món:</h2>
    <table>
        <thead>
            <tr>
                <th>Món</th>
                <th>Số lượng</th>
                <th>Giá</th>
                <th>Thành tiền</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->orderItems as $item)
            <tr>
                <td>{{ $item->menuItem->name }}</td>
                <td>{{ $item->quantity }}</td>
                <td>{{ number_format($item->unit_price, 0, ',', '.') }} đ</td>
                <td>{{ number_format($item->quantity * $item->unit_price, 0, ',', '.') }} đ</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</div>
@endsection

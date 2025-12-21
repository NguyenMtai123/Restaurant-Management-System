<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: DejaVu Sans; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 6px; }
        th { background: #f5f5f5; }
    </style>
</head>
<body>

<h2 style="text-align:center">BÁO CÁO ĐƠN HÀNG</h2>

<table>
    <thead>
        <tr>
            <th>Mã đơn</th>
            <th>Khách</th>
            <th>Ngày</th>
            <th>Tổng tiền</th>
            <th>Trạng thái</th>
        </tr>
    </thead>
    <tbody>
        @foreach($orders as $order)
        <tr>
            <td>{{ $order->order_number }}</td>
            <td>{{ $order->user?->name ?? 'Khách lẻ' }}</td>
            <td>{{ $order->created_at->format('d/m/Y') }}</td>
            <td>{{ number_format($order->total_amount) }} đ</td>
            <td>{{ strtoupper($order->status) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Báo cáo thống kê</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 13px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .logo {
            width: 80px;
            margin-bottom: 10px;
        }
        .title {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .subtitle {
            font-size: 13px;
            color: #666;
        }
        .summary {
            margin: 20px 0;
            width: 100%;
            border-collapse: collapse;
        }
        .summary td {
            padding: 8px;
            border: 1px solid #ddd;
        }
        .summary .label {
            font-weight: bold;
            background: #f8f8f8;
            width: 30%;
        }
        table.data {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table.data th,
        table.data td {
            border: 1px solid #ddd;
            padding: 8px;
            font-size: 12px;
        }
        table.data th {
            background: #f2f2f2;
            text-align: left;
        }
        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>

    <div class="header">
        <img src="{{ public_path('images/logo.png') }}" class="logo">
        <div class="title">BÁO CÁO THỐNG KÊ DOANH THU</div>
        <div class="subtitle">
            Từ {{ $from->format('d/m/Y') }} đến {{ $to->format('d/m/Y') }}
        </div>
    </div>

    <!-- Tổng kết -->
    <table class="summary">
        <tr>
            <td class="label">Tổng doanh thu</td>
            <td>{{ number_format($totalRevenue,0,',','.') }} ₫</td>
        </tr>
        <tr>
            <td class="label">Tổng đơn hoàn thành</td>
            <td>{{ $totalOrders }}</td>
        </tr>
        <tr>
            <td class="label">Tổng sản phẩm đã bán</td>
            <td>{{ $totalItems }}</td>
        </tr>
    </table>

    <!-- Chi tiết đơn hàng -->
    <table class="data">
        <thead>
            <tr>
                <th>#</th>
                <th>Mã đơn</th>
                <th>Ngày tạo</th>
                <th>Doanh thu</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $index => $order)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $order->order_number }}</td>
                <td>{{ \Carbon\Carbon::parse($order->created_at)->format('d/m/Y') }}</td>
                <td>{{ number_format($order->total_amount,0,',','.') }} ₫</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Xuất báo cáo lúc {{ now()->format('H:i d/m/Y') }}
    </div>

</body>
</html>


<div class="container">
    <h2>Danh sách hóa đơn</h2>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Số hóa đơn</th>
                <th>Khách hàng</th>
                <th>Loại</th>
                <th>Tổng tiền</th>
                <th>Trạng thái</th>
                <th>Ngày tạo</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr>
                <td>{{ $order->order_number }}</td>
                <td>{{ $order->user?->name ?? 'Khách vãng lai' }}</td>
                <td>{{ $order->order_type }}</td>
                <td>{{ number_format($order->total_amount) }}</td>
                <td>{{ $order->status }}</td>
                <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                <td>
                    <a href="{{ route('orders.show', $order) }}" class="btn btn-info btn-sm">Xem</a>

                    @if($order->status !== 'cancelled')
                    <form action="{{ route('orders.cancel', $order) }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-sm">Hủy</button>
                    </form>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

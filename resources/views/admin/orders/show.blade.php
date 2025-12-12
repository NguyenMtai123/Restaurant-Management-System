
<div class="container">
    <h2>Chi tiết hóa đơn: {{ $order->order_number }}</h2>

    <p><strong>Khách hàng:</strong> {{ $order->user?->name ?? 'Khách vãng lai' }}</p>
    <p><strong>Booking:</strong> {{ $order->booking?->id ?? 'Không có' }}</p>
    <p><strong>Loại:</strong> {{ $order->order_type }}</p>
    <p><strong>Tổng tiền:</strong> {{ number_format($order->total_amount) }}</p>
    <p><strong>Trạng thái:</strong> {{ $order->status }}</p>

    <h4>Chi tiết món</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Món</th>
                <th>Số lượng</th>
                <th>Đơn giá</th>
                <th>Ghi chú</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
            <tr>
                <td>{{ $item->menuItem->name }}</td>
                <td>{{ $item->quantity }}</td>
                <td>{{ number_format($item->unit_price) }}</td>
                <td>{{ $item->notes }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    @if($order->status !== 'cancelled')
    <form action="{{ route('orders.updateStatus', $order) }}" method="POST" class="mb-3">
        @csrf
        <label for="status">Cập nhật trạng thái</label>
        <select name="status" id="status" class="form-select w-auto d-inline-block">
            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
            <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed</option>
        </select>
        <button type="submit" class="btn btn-primary btn-sm">Cập nhật</button>
    </form>
    @endif
</div>

<head>
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
</head>
<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>🧾 Chi tiết hóa đơn: {{ $order->order_number }}</h2>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary btn-sm">⬅ Quay lại</a>
    </div>

    <div class="row g-3 mb-3">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <p><strong>Khách hàng:</strong> {{ $order->user?->name ?? 'Khách vãng lai' }}</p>
                    <p><strong>Tổng tiền:</strong> <span class="text-success fw-bold">{{ number_format($order->total_amount) }} đ</span></p>
                    <p><strong>Trạng thái:</strong>
                        @if($order->status == 'pending')
                            <span class="badge bg-warning text-dark">Pending</span>
                        @elseif($order->status == 'delivered')
                            <span class="badge bg-info text-dark">Delivered</span>
                        @elseif($order->status == 'completed')
                            <span class="badge bg-success">Completed</span>
                        @elseif($order->status == 'cancelled')
                            <span class="badge bg-danger">Cancelled</span>
                        @endif
                    </p>
                </div>
            </div>
        </div>

        @if($order->status !== 'cancelled')
        <div class="col-md-6 text-end">
            <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST" class="d-inline-flex align-items-center gap-2">
                    @csrf
                    @method('PUT') {{-- Thêm dòng này để Laravel nhận là PUT --}}
                    <label for="status" class="mb-0">Cập nhật trạng thái:</label>
                    <select name="status" id="status" class="form-select w-auto">
                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                        <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed</option>
                    </select>
                    <button type="submit" class="btn btn-primary btn-sm">Cập nhật</button>
                </form>
        </div>
        @endif
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-light">
            <h5 class="mb-0">Chi tiết món</h5>
        </div>
        <div class="card-body p-0">
            <table class="table table-striped table-hover mb-0">
                <thead class="table-light text-center">
                    <tr>
                        <th>Món</th>
                        <th>Số lượng</th>
                        <th>Đơn giá</th>
                        <th>Thành tiền</th>
                        <th>Ghi chú</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($order->orderItems as $item)
                    <tr class="text-center">
                        <td class="text-start">{{ $item->menuItem->name ?? '—' }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ number_format($item->unit_price) }} đ</td>
                        <td>{{ number_format($item->quantity * $item->unit_price) }} đ</td>
                        <td class="text-start">{{ $item->notes ?: '—' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted">Chưa có món nào</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý hóa đơn</title>

    <!-- Bootstrap CSS + Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>📄 Danh sách hóa đơn</h2>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm rounded-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle mb-0">
                    <thead class="table-light text-center">
                        <tr>
                            <th>Số hóa đơn</th>
                            <th>Khách hàng</th>
                            <th>Tổng tiền</th>
                            <th>Trạng thái</th>
                            <th>Ngày tạo</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                        <tr class="text-center">
                            <td>{{ $order->order_number }}</td>
                            <td>{{ $order->user?->name ?? 'Khách vãng lai' }}</td>
                            <td>{{ number_format($order->total_amount) }} đ</td>
                            <td>
                                <span class="badge
                                    @if($order->status === 'pending') bg-warning
                                    @elseif($order->status === 'delivered') bg-info
                                    @elseif($order->status === 'completed') bg-success
                                    @elseif($order->status === 'cancelled') bg-danger
                                    @endif">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <!-- Xem chi tiết -->
                                <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-info btn-sm mb-1">
                                    <i class="bi bi-eye"></i> Xem
                                </a>

                                <!-- Mở modal cập nhật trạng thái -->
                                @if($order->status !== 'cancelled')
                                <button class="btn btn-warning btn-sm mb-1" data-bs-toggle="modal" data-bs-target="#statusModal-{{ $order->id }}">
                                    <i class="bi bi-pencil-square"></i> Cập nhật
                                </button>
                                @endif

                                <!-- Hủy hóa đơn -->
                                @if($order->status !== 'cancelled')
                                <form action="{{ route('admin.orders.cancel', $order) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-sm mb-1" onclick="return confirm('Xác nhận hủy hóa đơn?')">
                                        <i class="bi bi-x-circle"></i> Hủy
                                    </button>
                                </form>
                                @endif
                            </td>
                        </tr>

                        <!-- Modal Cập nhật trạng thái -->
                        <div class="modal fade" id="statusModal-{{ $order->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Cập nhật trạng thái - {{ $order->order_number }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST">
                                            @csrf
                                            @method('PUT')

                                            <div class="mb-3">
                                                <label class="form-label">Trạng thái</label>
                                                <select name="status" class="form-select" required>
                                                    <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                                    <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>Delivered</option>
                                                    <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Completed</option>
                                                    <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                                </select>
                                            </div>

                                            <div class="text-end">
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="bi bi-save me-1"></i> Cập nhật
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">Chưa có hóa đơn nào</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

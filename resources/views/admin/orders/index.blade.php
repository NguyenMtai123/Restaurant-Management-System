@extends('admin.layouts.master')

@section('title', 'Quản lý đơn hàng - Take Away Express')
@section('page-title', 'Đơn hàng')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/orders.css') }}">
@endpush

@section('content')
    <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
        <div class="card-body p-3">
            <form method="GET" action="{{ route('admin.orders.index') }}">
                <div class="row align-items-center g-3">
                    <div class="col-md-4">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="bx bx-search text-muted"></i>
                            </span>
                            <input type="text" name="keyword" class="form-control border-start-0 ps-0"
                                placeholder="Tìm mã đơn, tên khách..." value="{{ request('keyword') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <select name="status" class="form-select" id="statusFilter">
                            <option value="all">Tất cả trạng thái</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Chờ xử lý</option>
                            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Hoàn thành</option>
                            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <input type="date" name="date" class="form-control" value="{{ request('date') }}">
                    </div>

                    <div class="col-md-1 ">
                        <button class="btn btn-outline-primary w-100">
                            <i class="bx bx-filter"></i> Lọc
                        </button>
                    </div>

                    <div class="col-md-2 text-md-end">
                        <a href="{{ route('admin.orders.export.pdf', request()->query()) }}"
                            class="btn btn-outline-danger w-100">
                            <i class="bx bxs-file-pdf"></i> Xuất PDF
                        </a>
                    </div>
                </div>
            </form>

        </div>
    </div>

    <div class="card border-0 shadow-sm" style="border-radius: 12px;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 order-table">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4">Mã đơn</th>
                            <th>Khách hàng</th>
                            <th>Ngày đặt</th>
                            <th>Tổng tiền</th>
                            {{-- <th>Thanh toán</th> --}}
                            <th>Trạng thái</th>
                            <th class="text-end pe-4">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                            <tr>
                                <td class="ps-4 fw-semibold">
                                    {{ $order->order_number }}
                                </td>
                                <td>
                                    {{ $order->user?->name ?? 'Khách vãng lai' }}
                                </td>
                                <td>
                                    {{ $order->created_at->format('d/m/Y H:i') }}
                                </td>
                                <td class="fw-bold">
                                    <span style="color:rgb(206, 15, 15)">{{ number_format($order->total_amount) }} đ</span>
                                </td>
                                {{-- <td>
                                    <span class="badge bg-info-subtle text-info">
                                        {{ strtoupper($order->payment->method ?? 'CASH') }}
                                    </span>
                                </td> --}}
                                <td>
                                    @php
                                        $statusMap = [
                                            'pending' => ['Chờ xử lý', 'warning'],
                                            'delivered' => ['Đang giao', 'info'],
                                            'completed' => ['Hoàn thành', 'success'],
                                            'cancelled' => ['Đã hủy', 'danger'],
                                        ];
                                        [$text, $color] = $statusMap[$order->status] ?? ['Không rõ', 'secondary'];
                                    @endphp

                                    <span class="badge rounded-pill bg-{{ $color }}">
                                        {{ $text }}
                                    </span>
                                </td>
                                <td class="text-end pe-4">
                                    <button class="btn btn-sm btn-info btn-view-order" data-id="{{ $order->id }}"
                                        title="Xem chi tiết">
                                        <i class="bx bx-show"></i>
                                    </button>
                                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                        data-bs-target="#statusModal-{{ $order->id }}" title="Cập nhật trạng thái">
                                        <i class="bx bx-edit"></i>
                                    </button>
                                    @if ($order->status === 'cancelled')
                                        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                            data-bs-target="#deleteModal-{{ $order->id }}" title="Hủy/Xóa đơn">
                                            <i class="bx bx-x"></i>
                                        </button>
                                    @endif
                                </td>
                            </tr>
                            @include('admin.partials.modals.update_status')
                            <div class="modal fade" id="deleteModal-{{ $order->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <form action="{{ route('admin.orders.cancel', $order) }}" method="POST">
                                            @csrf
                                            <div class="modal-header">
                                                <h5 class="modal-title text-danger">Hủy đơn hàng</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Bạn có chắc chắn muốn hủy đơn
                                                    <strong>{{ $order->order_number }}</strong> không?</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-light"
                                                    data-bs-dismiss="modal">Hủy</button>
                                                <button type="submit" class="btn btn-danger">Xác nhận hủy</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">
                                    Chưa có đơn hàng nào
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>
        </div>
        <div class="card-footer bg-white border-0 py-3">
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-muted small">
                    Hiển thị
                    <strong>{{ $orders->firstItem() }}</strong> –
                    <strong>{{ $orders->lastItem() }}</strong>
                    / {{ $orders->total() }} đơn hàng
                </div>
                {{ $orders->links('pagination::bootstrap-5') }}

            </div>
        </div>
    </div>
    @include('admin.partials.modals.order_detail')
@endsection

@push('scripts')
    <script>
        document.getElementById('statusFilter').addEventListener('change', function() {
            this.form.submit();
        });
    </script>
    <script src="{{ asset('js/orders.js') }}"></script>
    <script>
        document.querySelectorAll('.btn-view-order').forEach(btn => {
            btn.addEventListener('click', function() {
                const orderId = this.dataset.id;

                fetch(`/admin/orders/${orderId}`)
                    .then(res => res.json())
                    .then(data => {
                        // HEADER
                        document.getElementById('modalOrderId').innerText = data.order_number;
                        document.getElementById('modalCustomerName').innerText = data.customer.name;
                        document.getElementById('modalCustomerPhone').innerText = data.customer.phone;
                        document.getElementById('modalCustomerAddress').innerText = data.customer
                            .address;
                        document.getElementById('modalOrderDate').innerText = data.created_at;

                        // STATUS
                        const statusBadge = document.getElementById('modalOrderStatus');
                        statusBadge.className = `badge bg-${data.status_color}`;
                        statusBadge.innerText = data.status_text;

                        // ITEMS
                        const tbody = document.getElementById('modalOrderItems');
                        tbody.innerHTML = '';
                        data.items.forEach(item => {
                            tbody.innerHTML += `
                        <tr>
                            <td>${item.name}</td>
                            <td class="text-center">${item.qty}</td>
                            <td class="text-end">${item.price}</td>
                            <td class="text-end">${item.subtotal}</td>
                        </tr>
                    `;
                        });

                        // TOTAL + NOTE
                        document.getElementById('modalOrderTotal').innerText = data.total;
                        document.getElementById('modalOrderNote').innerText = data.note;

                        // SHOW MODAL
                        new bootstrap.Modal(document.getElementById('orderDetailModal')).show();
                    });
            });
        });
    </script>
@endpush

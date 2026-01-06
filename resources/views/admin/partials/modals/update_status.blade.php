<style>
    .status-card input {
        display: none;
    }

    .status-card .card {
        cursor: pointer;
        transition: all 0.25s ease;
    }

    .status-card input:checked+.card {
        box-shadow: 0 0 0 2px #0d6efd;
        transform: translateY(-2px);
    }

    .status-card .card:hover {
        transform: translateY(-3px);
    }
</style>

<div class="modal fade" id="statusModal-{{ $order->id }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg">

            <div class="modal-header bg-light">
                <div>
                    <h5 class="modal-title fw-bold mb-1">
                        Cập nhật trạng thái đơn
                    </h5>
                    <small class="text-muted">
                        Mã đơn: <strong>{{ $order->order_number }}</strong>
                    </small>
                </div>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="modal-body">
                    @php
                        $statusMap = [
                            'pending' => ['Chờ xử lý', 'warning', 'bx-time'],
                            'delivered' => ['Đang giao', 'info', 'bx-package'],
                            'completed' => ['Hoàn thành', 'success', 'bx-check-circle'],
                            'cancelled' => ['Đã hủy', 'danger', 'bx-x-circle'],
                        ];
                        [$currentText, $currentColor, $currentIcon] = $statusMap[$order->status];
                    @endphp

                    <div class="alert alert-{{ $currentColor }} d-flex align-items-center gap-2">
                        <i class="bx {{ $currentIcon }} fs-4"></i>
                        <strong>Trạng thái hiện tại:</strong> {{ $currentText }}
                    </div>

                    <h6 class="fw-semibold mb-3">Chọn trạng thái mới</h6>

                    <div class="row g-3">

                        {{-- PENDING --}}
                        <div class="col-md-3">
                            <label class="status-card">
                                <input type="radio" name="status" value="pending"
                                    {{ $order->status === 'pending' ? 'checked' : '' }}>
                                <div class="card text-center border-warning">
                                    <div class="card-body">
                                        <i class="bx bx-time fs-2 text-warning"></i>
                                        <p class="mt-2 mb-0 fw-semibold">Chờ xử lý</p>
                                    </div>
                                </div>
                            </label>
                        </div>

                        {{-- DELIVERED --}}
                        <div class="col-md-3">
                            <label class="status-card">
                                <input type="radio" name="status" value="delivered"
                                    {{ $order->status === 'delivered' ? 'checked' : '' }}>
                                <div class="card text-center border-info">
                                    <div class="card-body">
                                        <i class="bx bx-package fs-2 text-info"></i>
                                        <p class="mt-2 mb-0 fw-semibold">Đang giao</p>
                                    </div>
                                </div>
                            </label>
                        </div>

                        {{-- COMPLETED --}}
                        <div class="col-md-3">
                            <label class="status-card">
                                <input type="radio" name="status" value="completed"
                                    {{ $order->status === 'completed' ? 'checked' : '' }}>
                                <div class="card text-center border-success">
                                    <div class="card-body">
                                        <i class="bx bx-check-circle fs-2 text-success"></i>
                                        <p class="mt-2 mb-0 fw-semibold">Hoàn thành</p>
                                    </div>
                                </div>
                            </label>
                        </div>

                        {{-- CANCEL --}}
                        <div class="col-md-3">
                            <label class="status-card">
                                <input type="radio" name="status" value="cancelled"
                                    {{ $order->status === 'cancelled' ? 'checked' : '' }}>
                                <div class="card text-center border-danger">
                                    <div class="card-body">
                                        <i class="bx bx-x-circle fs-2 text-danger"></i>
                                        <p class="mt-2 mb-0 fw-semibold">Hủy đơn</p>
                                    </div>
                                </div>
                            </label>
                        </div>

                    </div>

                    {{-- CẢNH BÁO --}}
                    <div class="alert alert-danger mt-4 small">
                        ⚠ Nếu chuyển sang <strong>Hủy đơn</strong>, hành động này không thể hoàn tác.
                    </div>

                </div>

                {{-- FOOTER --}}
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                        Đóng
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bx bx-save"></i> Lưu thay đổi
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

@extends('admin.layouts.master')

@section('title', 'Quản lý khách hàng - Take Away Express')
@section('page-title', 'Khách hàng')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/customers.css') }}">
@endpush

@section('content')
            <div class="row g-4 mb-4">
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body d-flex align-items-center">
                            <div class="icon-box bg-primary-subtle text-primary me-3">
                                <i class='bx bx-user'></i>
                            </div>
                            <div>
                                <h6 class="text-muted mb-1">Tổng khách hàng</h6>
                                <h4 class="fw-bold mb-0">{{ $users->count() }}</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body d-flex align-items-center">
                            <div class="icon-box bg-success-subtle text-success me-3">
                                <i class='bx bx-user-check'></i>
                            </div>
                            <div>
                                <h6 class="text-muted mb-1">Đang hoạt động</h6>
                                <h4 class="fw-bold mb-0">
                                    {{ $users->where('status','active')->count() }}
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body d-flex align-items-center">
                            <div class="icon-box bg-danger-subtle text-danger me-3">
                                <i class='bx bx-user-x'></i>
                            </div>
                            <div>
                                <h6 class="text-muted mb-1">Bị khóa</h6>
                                <h4 class="fw-bold mb-0">
                                    {{ $users->where('status','banned')->count() }}
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <div class="row g-3 align-items-center">
                        {{-- FORM FILTER --}}
                        <form method="GET" class="col-md-9 row g-2">
                           <div class="col-md-5">
                                <div class="input-group">
                                    <span class="input-group-text bg-white">
                                        <i class='bx bx-search'></i>
                                    </span>
                                    <input type="text"
                                        name="keyword"
                                        class="form-control"
                                        placeholder="Tìm theo tên, SĐT hoặc Email"
                                        value="{{ request('keyword') }}">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <select name="sort" class="form-select" onchange="this.form.submit()">
                                    <option value="date_desc" {{ request('sort')=='date_desc'?'selected':'' }}>
                                        Mới nhất
                                    </option>
                                    <option value="date_asc" {{ request('sort')=='date_asc'?'selected':'' }}>
                                        Cũ nhất
                                    </option>
                                    <option value="name_asc" {{ request('sort')=='name_asc'?'selected':'' }}>
                                        Tên A → Z
                                    </option>
                                    <option value="name_desc" {{ request('sort')=='name_desc'?'selected':'' }}>
                                        Tên Z → A
                                    </option>
                                </select>
                            </div>

                            <div class="col-md-3 text-start">
                                <button class="btn btn-primary">
                                    <i class="bx bx-filter"></i> Lọc
                                </button>
                            </div>

                        </form>

                        {{-- ADD BUTTON --}}
                        <div class="col-md-3 text-end">
                            <button
                                type="button"
                                class="btn btn-primary"
                                data-bs-toggle="modal"
                                data-bs-target="#addCustomerModal">
                                <i class='bx bx-user-plus'></i> Thêm khách hàng
                            </button>
                        </div>

                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4">Khách hàng</th>
                                    <th>Liên hệ</th>
                                    <th>Ngày tham gia</th>
                                    <th>Đơn hàng</th>
                                    <th>Tổng chi tiêu</th>
                                    <th>Trạng thái</th>
                                    <th class="text-end pe-4">Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($users as $user)
                                    <tr>
                                        {{-- KHÁCH --}}
                                        <td class="ps-4">
                                            <div class="d-flex align-items-center">
                                                <img src="{{ $user->avatar
                                                    ? asset('images/avatars/'.$user->avatar)
                                                    : asset('images/avatar-default.png') }}"
                                                    class="rounded-circle me-2"
                                                    width="40" height="40">
                                                <div>
                                                    <div class="fw-semibold">{{ $user->name }}</div>
                                                    <small class="text-muted">{{ ucfirst($user->role) }}</small>
                                                </div>
                                            </div>
                                        </td>

                                        {{-- LIÊN HỆ --}}
                                        <td>
                                            <div><i class="bx bx-phone"></i> {{ $user->phone ?? '—' }}</div>
                                            <div class="small text-muted">
                                                <i class="bx bx-envelope"></i> {{ $user->email }}
                                            </div>
                                        </td>

                                        {{-- NGÀY --}}
                                        <td>{{ $user->created_at->format('d/m/Y') }}</td>

                                        {{-- SỐ ĐƠN --}}
                                        <td class="text-center">
                                            {{ $user->orders()->count() }} đơn
                                        </td>

                                        {{-- TỔNG CHI --}}
                                        <td class="fw-bold text-danger">
                                            {{ number_format($user->orders()->sum('total_amount')) }} đ
                                        </td>

                                        {{-- TRẠNG THÁI --}}
                                        <td>
                                            @php
                                                $map = [
                                                    'active' => ['Hoạt động','success'],
                                                    'inactive' => ['Tạm khóa','secondary'],
                                                    'banned' => ['Bị cấm','danger'],
                                                ];
                                                [$text,$color] = $map[$user->status];
                                            @endphp
                                            <span class="badge bg-{{ $color }}">{{ $text }}</span>
                                        </td>

                                        {{-- ACTION --}}
                                        <td class="text-end pe-4">
                                           <button
                                                class="action-btn btn-view-customer "
                                                data-id="{{ $user->id }}"
                                                title="Xem chi tiết">
                                                <i class="bx bx-show"></i>
                                            </button>

                                            <button class="action-btn editor-link text-warning"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#editCustomerModal-{{ $user->id }}">
                                                <i class="bx bx-edit"></i>
                                            </button>

                                            <button class="action-btn delete-link text-danger"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#deleteCustomerModal-{{ $user->id }}">
                                                <i class="bx bx-trash"></i>
                                            </button>

                                        </td>
                                    </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">
                                        <i class="bx bx-search-alt-2 fs-4 d-block mb-1"></i>
                                        Không tìm thấy khách hàng phù hợp
                                    </td>
                                </tr>
                                @endforelse

                            </tbody>
                        </table>

                    </div>
                </div>
                <div class="card-footer bg-white border-0 py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted">
                            Hiển thị {{ $users->firstItem() }} –
                            {{ $users->lastItem() }} / {{ $users->total() }} khách
                        </small>

                        {{ $users->links('pagination::bootstrap-5') }}
                    </div>
                </div>

            </div>

        @include('admin.partials.modals.add_customer')
        @include('admin.partials.modals.edit_customer')
        @include('admin.partials.modals.delete_customer')
        @include('admin.partials.modals.detail_customer')
@endsection

@push('scripts')
    <script src="{{ asset('js/customers.js') }}"></script>
     <script>
    document.addEventListener('click', function (e) {
        const btn = e.target.closest('.btn-view-customer');
        if (!btn) return;

        const userId = btn.dataset.id;

        fetch(`/admin/customers/${userId}`)
            .then(res => res.json())
            .then(data => {

                // BASIC INFO
                document.getElementById('modalAvatar').src   = data.avatar;
                document.getElementById('modalName').innerText   = data.name;
                document.getElementById('modalEmail').innerText  = data.email ?? '—';
                document.getElementById('modalPhone').innerText  = data.phone ?? '—';
                document.getElementById('modalAddress').innerText= data.address ?? '—';

                // ORDER HISTORY
                let html = '';
                if (data.orders.length === 0) {
                    html = `<tr><td colspan="4" class="text-muted text-center">Chưa có đơn hàng</td></tr>`;
                } else {
                    data.orders.forEach(o => {
                        html += `
                            <tr>
                                <td>${o.order_number}</td>
                                <td>${o.date}</td>
                                <td class="fw-bold text-danger">${o.total}</td>
                                <td>
                                    <span class="badge bg-${statusColor(o.status)}">
                                        ${statusText(o.status)}
                                    </span>
                                </td>
                            </tr>`;
                    });
                }

                document.getElementById('modalHistoryBody').innerHTML = html;

                // SHOW MODAL
                new bootstrap.Modal(document.getElementById('customerDetailModal')).show();
            });
    });

    // STATUS FORMAT
    function statusText(status) {
        return {
            pending: 'Chờ xử lý',
            delivered: 'Đang giao',
            completed: 'Hoàn thành',
            cancelled: 'Đã hủy'
        }[status] ?? status;
    }

    function statusColor(status) {
        return {
            pending: 'warning',
            delivered: 'info',
            completed: 'success',
            cancelled: 'danger'
        }[status] ?? 'secondary';
    }
    </script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.avatar-input').forEach(input => {
        input.addEventListener('change', function () {
            if (this.files[0]) {
                const reader = new FileReader();
                reader.onload = e =>
                    document.getElementById(this.dataset.preview).src = e.target.result;
                reader.readAsDataURL(this.files[0]);
            }
        });
    });
});

</script>
@endpush

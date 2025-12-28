@extends('admin.layouts.master')

@section('title', 'Quản lý nhân viên - Take Away Express')
@section('page-title', 'Nhân viên')

@push('styles')
   <link rel="stylesheet" href="{{ asset('css/employees.css') }}">
@endpush

@section('content')
            <div class="row g-4 mb-4">
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body d-flex align-items-center">
                            <div class="icon-box bg-primary-subtle text-primary me-3">
                                <i class="bx bx-group"></i>
                            </div>
                            <div>
                                <h6 class="text-muted mb-1">Tổng nhân viên</h6>
                                <h4 class="fw-bold mb-0">{{ $totalEmployees }}</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body d-flex align-items-center">
                            <div class="icon-box bg-success-subtle text-success me-3">
                                <i class="bx bx-user-check"></i>
                            </div>
                            <div>
                                <h6 class="text-muted mb-1">Đang hoạt động</h6>
                                <h4 class="fw-bold mb-0">{{ $activeEmployees }}</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body d-flex align-items-center">
                            <div class="icon-box bg-danger-subtle text-danger me-3">
                                <i class="bx bx-user-x"></i>
                            </div>
                            <div>
                                <h6 class="text-muted mb-1">Bị khóa</h6>
                                <h4 class="fw-bold mb-0">{{ $bannedEmployees }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="card border-0 shadow-sm mb-4" style="border-radius:12px;">
                <div class="card-body p-3">
                     <div class="row g-3 align-items-center">
                        {{-- FORM FILTER --}}
                        <form method="GET" class="col-md-10 row g-2">{{-- SEARCH --}}
                            <div class="col-md-4">
                                <div class="input-group">
                                    <span class="input-group-text bg-white">
                                        <i class="bx bx-search"></i>
                                    </span>
                                    <input type="text"
                                        name="keyword"
                                        class="form-control"
                                        placeholder="Tìm tên, SĐT hoặc Email"
                                        value="{{ request('keyword') }}">
                                </div>
                            </div>

                            {{-- FILTER ROLE --}}
                            <div class="col-md-3">
                                <select name="role" class="form-select" onchange="this.form.submit()">
                                    <option value="all">Tất cả bộ phận</option>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->name }}"
                                            {{ request('role') == $role->name ? 'selected' : '' }}>
                                            {{ $role->label }}
                                        </option>
                                    @endforeach
                                </select>

                            </div>

                            {{-- SORT --}}
                            <div class="col-md-3">
                                <select name="sort" class="form-select" onchange="this.form.submit()">
                                    <option value="date_desc" {{ request('sort')=='date_desc'?'selected':'' }}>Mới nhất</option>
                                    <option value="date_asc" {{ request('sort')=='date_asc'?'selected':'' }}>Cũ nhất</option>
                                    <option value="name_asc" {{ request('sort')=='name_asc'?'selected':'' }}>Tên A → Z</option>
                                    <option value="name_desc" {{ request('sort')=='name_desc'?'selected':'' }}>Tên Z → A</option>
                                </select>
                            </div>

                            {{-- BUTTON --}}
                            <div class="col-md-2 text-start">
                                <button class="btn btn-primary">
                                    <i class="bx bx-filter"></i> Lọc
                                </button>
                            </div>
                        </form>

                        <div class="col-md-2 text-end">
                            <button class="btn btn-primary text-white"
                                    data-bs-toggle="modal"
                                    data-bs-target="#addEmployeeModal">
                                <i class="bx bx-user-plus"></i> Thêm nhân viên
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
                                    <th class="ps-4">Nhân viên</th>
                                    <th>Bộ phận</th>
                                    <th>Liên hệ</th>
                                    <th>Ngày vào làm</th>
                                    <th>Trạng thái</th>
                                    <th class="text-end pe-4">Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($employees as $user)
                                    <tr>
                                        <!-- Nhân viên -->
                                        <td class="ps-4">
                                            <div class="d-flex align-items-center gap-2">
                                                <img src="{{ $user->avatar
                                                    ? asset('images/avatars/'.$user->avatar)
                                                    : asset('images/avatars/default.png') }}"
                                                    class="rounded-circle"
                                                    width="40" height="40">

                                                <div>
                                                    <div class="fw-semibold">{{ $user->name }}</div>
                                                    <small class="text-muted">ID: {{ $user->id }}</small>
                                                </div>
                                            </div>
                                        </td>

                                        <!-- Bộ phận -->
                                        <td>
                                           <span class="badge bg-secondary">
                                                {{ $user->role->label ?? $user->role->name }}
                                            </span>
                                        </td>

                                        <!-- Liên hệ -->
                                        <td>
                                            <div>{{ $user->phone ?? '—' }}</div>
                                            <small class="text-muted">{{ $user->email }}</small>
                                        </td>

                                        <!-- Ngày vào làm -->
                                        <td>{{ $user->created_at->format('d/m/Y') }}</td>

                                        <!-- Trạng thái -->
                                        <td>
                                            <span class="badge
                                                @if($user->status=='active') bg-success
                                                @elseif($user->status=='inactive') bg-warning
                                                @else bg-danger
                                                @endif">
                                                {{ ucfirst($user->status) }}
                                            </span>
                                        </td>

                                        <!-- Hành động -->
                                        <td class="text-end pe-4">
                                            <button class="action-btn"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#editEmployeeModal-{{ $user->id }}">
                                                <i class="bx bx-edit"></i>
                                            </button>

                                            <button class="action-btn text-danger"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#deleteEmployeeModal-{{ $user->id }}">
                                                <i class="bx bx-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-5">
                                            <h6 class="text-muted mb-1">Không có nhân viên nào</h6>
                                            <p class="text-muted small mb-3">
                                                Chưa có nhân viên phù hợp với bộ lọc hiện tại
                                            </p>
                                            <button class="btn btn-primary"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#addEmployeeModal">
                                                <i class="bx bx-user-plus"></i> Thêm nhân viên
                                            </button>
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
                            {{ $employees->firstItem() }} –
                            {{ $employees->lastItem() }}
                            / {{ $employees->total() }} nhân viên
                        </div>

                        {{ $employees->links('pagination::bootstrap-5') }}

                    </div>
                </div>
            </div>
        @include('admin.partials.modals.add_employees')
        @include('admin.partials.modals.edit_employees')
        @include('admin.partials.modals.delete_employees')
@endsection

@push('scripts')
    <script src="{{ asset('js/employees.js') }}"></script>
    <script>
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.avatar-input').forEach(input => {
        input.addEventListener('change', function () {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = e => {
                    const preview = document.getElementById(this.dataset.preview);
                    if (preview) preview.src = e.target.result;
                }
                reader.readAsDataURL(this.files[0]);
            }
        });
    });
});
</script>

@endpush

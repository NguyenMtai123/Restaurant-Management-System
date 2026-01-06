@extends('admin.layouts.master')
@php
    use Carbon\Carbon;
@endphp

@section('title','Quản lý mã giảm giá')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">🎟 Quản lý mã giảm giá</h4>
        <small class="text-muted">Chọn mã & người dùng để gửi email</small>
    </div>

    <div class="d-flex gap-2">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createCoupon">
            <i class="bx bx-plus"></i> Thêm mã
        </button>
        <button type="button" class="btn btn-success" onclick="document.getElementById('sendForm').submit()">
            <i class="bx bx-mail-send"></i> Gửi mã đã chọn
        </button>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-12">
        <form id="sendForm" method="POST" action="{{ route('admin.coupons.sendMultiple') }}">
            @csrf

            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="card shadow-sm">
                        <div class="card-header bg-light d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <input type="checkbox" id="checkAllCoupons" class="form-check-input me-2">
                                <strong>Danh sách mã giảm giá</strong>
                            </div>

                            <div style="min-width:260px;">
                                <input id="searchCoupon" type="text" class="form-control form-control-sm" placeholder="🔍 Tìm mã / tên">
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th width="30"></th>
                                        <th>Mã</th>
                                        <th>Giá trị</th>
                                        <th>Đã gửi</th>
                                        <th>Đã dùng</th>
                                        <th>Hạn</th>
                                        <th>Trạng thái</th>
                                        <th class="text-end">Thao tác</th>
                                    </tr>
                                </thead>

                                <tbody id="couponTable">
                                @forelse($coupons as $coupon)
                                    <tr data-search="{{ strtolower($coupon->code.' '.$coupon->name) }}">
                                        <td>
                                            <input type="checkbox"
                                                   class="form-check-input"
                                                   name="coupons[]"
                                                   value="{{ $coupon->id }}">
                                        </td>

                                        <td>
                                            <strong>{{ $coupon->code }}</strong><br>
                                            <small class="text-muted">{{ $coupon->name }}</small>
                                        </td>

                                        <td class="fw-semibold">
                                            {{ $coupon->type == 'percent'
                                                ? $coupon->value.'%'
                                                : number_format($coupon->value).'đ' }}
                                        </td>

                                        <td>
                                            <span class="badge bg-info">
                                                {{ $coupon->users()->count() }}
                                            </span>
                                        </td>

                                        <td>
                                            <span class="badge bg-secondary">
                                                {{ $coupon->users()->wherePivot('is_used', true)->count() }}
                                                / {{ $coupon->max_uses }}
                                            </span>
                                        </td>

                                        <td>{{Date::parse($coupon->end_date)->format('d/m/Y') }}</td>

                                        <td>
                                            <span class="badge rounded-pill
                                                {{ $coupon->isAvailable() ? 'bg-success' : 'bg-danger' }}">
                                                {{ $coupon->isAvailable() ? 'Còn hiệu lực' : 'Hết hạn' }}
                                            </span>
                                        </td>

                                        <td class="text-end">
                                            <button type="button"
                                                    class="btn btn-sm btn-warning"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#edit{{ $coupon->id }}"
                                                    title="Sửa">
                                                <i class="bx bx-edit"></i>
                                            </button>

                                            <button type="button"
                                                    class="btn btn-sm btn-danger"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#delete{{ $coupon->id }}"
                                                    title="Xóa">
                                                <i class="bx bx-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center text-muted py-4">
                                            Chưa có mã giảm giá
                                        </td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="card-footer bg-white d-flex justify-content-between align-items-center">
                            <div>
                                <small class="text-muted">
                                    Hiển thị {{ $coupons->firstItem() ?? 0 }} – {{ $coupons->lastItem() ?? 0 }} / {{ $coupons->total() ?? 0 }}
                                </small>
                            </div>

                            {{ $coupons->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>

               <div class="col-lg-4">
                    <div class="card shadow-sm">
                        <div class="card-header bg-light position-relative">
                            <strong>Người nhận</strong>

                            <div class="mt-2 position-relative">
                                <input id="searchUser"
                                    type="text"
                                    class="form-control form-control-sm"
                                    placeholder="🔍 Tìm tên hoặc email"
                                    autocomplete="off">

                                <div id="userSuggest"
                                    class="list-group position-absolute w-100 shadow"
                                    style="z-index:1000; display:none; max-height:260px; overflow:auto">
                                </div>
                            </div>
                        </div>

                        <div class="card-body p-2" style="max-height:420px; overflow-y:auto">
                            <label class="mb-2 d-block">
                                <input type="checkbox" id="checkAllUsers" class="form-check-input me-1">
                                Chọn tất cả
                            </label>

                            @foreach(\App\Models\User::select('id','name','email')->orderBy('name')->get() as $user)
                                <label class="user-item d-flex align-items-center p-2 rounded hover-bg mb-1"
                                    data-id="{{ $user->id }}"
                                    data-search="{{ strtolower($user->name.' '.$user->email) }}">
                                    <input type="checkbox"
                                        class="form-check-input me-2"
                                        name="users[]"
                                        value="{{ $user->id }}">
                                    <div>
                                        <div class="fw-semibold">{{ $user->name }}</div>
                                        <small class="text-muted">{{ $user->email }}</small>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>

            </div>

        </form>
    </div>
</div>

<div class="modal fade" id="createCoupon" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <form method="POST" action="{{ route('admin.coupons.store') }}">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">➕ Thêm mã giảm giá</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Mã</label>
                        <input name="code" class="form-control" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Tên</label>
                        <input name="name" class="form-control" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Loại</label>
                        <select name="type" class="form-select">
                            <option value="percent">%</option>
                            <option value="fixed">Tiền</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Giá trị</label>
                        <input type="number" name="value" class="form-control" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Số lượt dùng</label>
                        <input type="number" name="max_uses" class="form-control" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Đơn tối thiểu</label>
                        <input type="number" name="min_order" class="form-control">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Bắt đầu</label>
                        <input class="form-control" type="date" name="start_date" value="{{ now()->toDateString() }}">

                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Kết thúc</label>
                        <input class="form-control" type="date" name="end_date" value="{{ now()->toDateString() }}">
                    </div>

                    <div class="col-md-12">
                        <label class="form-label">Mô tả</label>
                        <textarea name="description"
                                class="form-control"
                                rows="3"
                                placeholder="Mô tả chi tiết mã giảm giá (hiển thị trong email)">
                        </textarea>
                    </div>


                    <div class="col-md-12">
                        <label>
                            <input type="checkbox" name="is_active" value="1" checked>
                            Kích hoạt
                        </label>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-primary">Lưu</button>
                </div>
            </div>
        </form>
    </div>
</div>

@foreach($coupons as $coupon)
    {{-- EDIT --}}
    <div class="modal fade" id="edit{{ $coupon->id }}" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <form method="POST" action="{{ route('admin.coupons.update', $coupon) }}">
                @csrf
                @method('PUT')

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">✏ Sửa mã {{ $coupon->code }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body row g-3">
                        <div class="col-md-6">
                            <label>Mã</label>
                            <input name="code" value="{{ $coupon->code }}" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label>Tên</label>
                            <input name="name" value="{{ $coupon->name }}" class="form-control" required>
                        </div>

                        <div class="col-md-4">
                            <label>Loại</label>
                            <select name="type" class="form-select">
                                <option value="percent" @selected($coupon->type=='percent')>%</option>
                                <option value="fixed" @selected($coupon->type=='fixed')>Tiền</option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label>Giá trị</label>
                            <input name="value" value="{{ $coupon->value }}" class="form-control" required>
                        </div>

                        <div class="col-md-4">
                            <label>Số lượt</label>
                            <input name="max_uses" value="{{ $coupon->max_uses }}" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label>Bắt đầu</label>
                            <input type="date" name="start_date"
                                   value="{{Date::parse($coupon->start_date)->format('Y-m-d') }}"
                                   class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label>Kết thúc</label>
                            <input type="date" name="end_date"
                                   value="{{Date::parse($coupon->end_date)->format('Y-m-d') }}"
                                   class="form-control" required>
                        </div>

                        <div class="col-md-12">
                            <label>Mô tả</label>
                            <textarea name="description"
                                    class="form-control"
                                    rows="3">{{ $coupon->description }}</textarea>
                        </div>


                        <div class="col-md-12">
                            <label>
                                <input type="checkbox" name="is_active" value="1" @checked($coupon->is_active)>
                                Kích hoạt
                            </label>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-warning">Cập nhật</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- DELETE --}}
    <div class="modal fade" id="delete{{ $coupon->id }}" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <form method="POST" action="{{ route('admin.coupons.destroy', $coupon) }}">
                @csrf
                @method('DELETE')

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-danger">Xóa mã {{ $coupon->code }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body text-center">
                        Bạn chắc chắn muốn xóa mã <strong>{{ $coupon->code }}</strong> ?
                    </div>

                    <div class="modal-footer justify-content-center">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-danger">Xóa</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endforeach

<style>
.hover-bg:hover {
    background: #f5f7fa;
    cursor: pointer;
}
.user-item { cursor: pointer; }
</style>

{{-- JS --}}
<script>
/* CHECK ALL COUPONS */
document.getElementById('checkAllCoupons')?.addEventListener('change', function () {
    document.querySelectorAll('input[name="coupons[]"]')
        .forEach(cb => cb.checked = this.checked);
});

/* CHECK ALL USERS */
document.getElementById('checkAllUsers')?.addEventListener('change', function () {
    document.querySelectorAll('input[name="users[]"]')
        .forEach(cb => cb.checked = this.checked);
});

/* SEARCH USER (realtime) */
document.getElementById('searchUser')?.addEventListener('input', function () {
    let keyword = this.value.toLowerCase();
    document.querySelectorAll('.user-item').forEach(item => {
        item.style.display = item.dataset.search.includes(keyword) ? 'flex' : 'none';
    });
});

/* SEARCH COUPON (realtime) */
document.getElementById('searchCoupon')?.addEventListener('input', function () {
    let key = this.value.toLowerCase();
    document.querySelectorAll('#couponTable tr').forEach(tr => {
        const s = tr.dataset.search || '';
        tr.style.display = s.includes(key) ? '' : 'none';
    });
});
</script>
<script>
const searchInput = document.getElementById('searchUser');
const suggestBox  = document.getElementById('userSuggest');
const users       = document.querySelectorAll('.user-item');

/* AUTOCOMPLETE USER */
searchInput?.addEventListener('input', function () {
    const key = this.value.toLowerCase().trim();
    suggestBox.innerHTML = '';

    if (!key) {
        suggestBox.style.display = 'none';
        return;
    }

    let count = 0;

    users.forEach(item => {
        if (count >= 6) return;

        if (item.dataset.search.includes(key)) {
            const name  = item.querySelector('.fw-semibold').innerText;
            const email = item.querySelector('small').innerText;
            const checkbox = item.querySelector('input[type="checkbox"]');

            const div = document.createElement('div');
            div.className = 'list-group-item list-group-item-action';
            div.innerHTML = `<strong>${name}</strong><br><small>${email}</small>`;

            div.onclick = () => {
                checkbox.checked = true;
                item.scrollIntoView({ behavior: 'smooth', block: 'center' });
                searchInput.value = '';
                suggestBox.style.display = 'none';
            };

            suggestBox.appendChild(div);
            count++;
        }
    });

    suggestBox.style.display = count ? 'block' : 'none';
});

/* CLICK NGOÀI → ẨN */
document.addEventListener('click', e => {
    if (!searchInput.contains(e.target)) {
        suggestBox.style.display = 'none';
    }
});

/* CHECK ALL USERS */
document.getElementById('checkAllUsers')?.addEventListener('change', function () {
    document.querySelectorAll('input[name="users[]"]')
        .forEach(cb => cb.checked = this.checked);
});
</script>

@endsection

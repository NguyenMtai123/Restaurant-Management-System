@extends('admin.layouts.master')

@section('title', 'Quản lý vai trò')

@section('content')
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Danh sách vai trò</h3>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addRoleModal">
            <i class="bx bx-plus"></i> Thêm vai trò
        </button>
    </div>
    <table class="table table-hover align-middle">
        <thead class="table-light">
            <tr>
                <th>#</th>
                <th>Tên vai trò</th>
                <th>Nhãn</th>
                <th class="text-end">Hành động</th>
            </tr>
        </thead>
        <tbody>
            @forelse($roles as $role)
            <tr>
                <td>{{ $role->id }}</td>
                <td>{{ $role->name }}</td>
                <td>{{ $role->label }}</td>
                <td class="text-end">
                    <button class="btn btn-sm btn-info"
                        data-bs-toggle="modal"
                        data-bs-target="#permissionModal-{{ $role->id }}">
                        <i class="bx bx-shield-quarter"></i>
                    </button>

                    <button class="btn btn-sm btn-warning"
                        data-bs-toggle="modal"
                        data-bs-target="#editRoleModal-{{ $role->id }}">
                        <i class="bx bx-edit"></i>
                    </button>

                    <button class="btn btn-sm btn-danger"
                        data-bs-toggle="modal"
                        data-bs-target="#deleteRoleModal-{{ $role->id }}">
                        <i class="bx bx-trash"></i>
                    </button>
                </td>

            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center">Chưa có vai trò nào</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{ $roles->links('pagination::bootstrap-5') }}
</div>

{{-- Add Modal --}}
<div class="modal fade" id="addRoleModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form action="{{ route('admin.roles.store') }}" method="POST" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title">Thêm vai trò mới</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Tên vai trò</label>
                    <input type="text" name="name" class="form-control" placeholder="Nhập tên vai trò" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Nhãn</label>
                    <input type="text" name="label" class="form-control" placeholder="Nhập nhãn" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <button type="submit" class="btn btn-primary">Thêm vai trò</button>
            </div>
        </form>
    </div>
</div>

{{-- Edit & Delete Modals --}}
@foreach($roles as $role)
<!-- Edit Modal -->
<div class="modal fade" id="editRoleModal-{{ $role->id }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form action="{{ route('admin.roles.update', $role->id) }}" method="POST" class="modal-content">
            @csrf
            @method('PUT')
            <div class="modal-header">
                <h5 class="modal-title">Sửa vai trò</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Tên vai trò</label>
                    <input type="text" name="name" class="form-control" value="{{ $role->name }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Nhãn</label>
                    <input type="text" name="label" class="form-control" value="{{ $role->label }}" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <button type="submit" class="btn btn-warning">Lưu thay đổi</button>
            </div>
        </form>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteRoleModal-{{ $role->id }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form action="{{ route('admin.roles.destroy', $role->id) }}" method="POST" class="modal-content">
            @csrf
            @method('DELETE')
            <div class="modal-header">
                <h5 class="modal-title text-danger">Xóa vai trò</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                Bạn có chắc chắn muốn xóa vai trò <strong>{{ $role->name }}</strong> không?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <button type="submit" class="btn btn-danger">Xóa</button>
            </div>
        </form>
    </div>
</div>
@endforeach
{{-- Permission Modals --}}
@foreach($roles as $role)
<!-- Permission Modal -->
<div class="modal fade" id="permissionModal-{{ $role->id }}" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <form method="POST"
              action="{{ route('admin.roles.permissions', $role->id) }}"
              class="modal-content">
            @csrf

            <div class="modal-header align-items-center">
                <h5 class="modal-title">
                    <i class="bx bx-shield-quarter me-1"></i>
                    Phân quyền:
                    <strong>{{ $role->label }}</strong>
                </h5>

                <div class="form-check ms-auto me-3">
                    <input class="form-check-input select-all"
                        type="checkbox"
                        data-role="{{ $role->id }}"
                        id="selectAll-{{ $role->id }}">
                    <label class="form-check-label fw-semibold"
                        for="selectAll-{{ $role->id }}">
                        Chọn tất cả
                    </label>
                </div>

                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>


            <div class="modal-body">
                <div class="row g-3 permission-box"
                    data-role="{{ $role->id }}">

                    @foreach($permissions as $permission)
                    <div class="col-md-4">
                        <div class="border rounded-3 p-2 h-100 permission-item">
                            <label class="form-check d-flex align-items-center gap-2">
                                <input class="form-check-input permission-checkbox"
                                    type="checkbox"
                                    name="permissions[]"
                                    value="{{ $permission->id }}"
                                    data-role="{{ $role->id }}"
                                    {{ $role->permissions->contains($permission->id) ? 'checked' : '' }}>
                                <span class="form-check-label">
                                    {{ $permission->label }}
                                </span>
                            </label>
                        </div>
                    </div>
                    @endforeach

                </div>
            </div>


            <div class="modal-footer">
                <button type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal">
                    Hủy
                </button>
                <button type="submit"
                        class="btn btn-primary">
                    Lưu quyền
                </button>
            </div>
        </form>
    </div>
</div>
@endforeach
@endsection
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    // Chọn tất cả
    document.querySelectorAll('.select-all').forEach(selectAll => {
        selectAll.addEventListener('change', function () {
            const roleId = this.dataset.role;
            const checkboxes = document.querySelectorAll(
                `.permission-checkbox[data-role="${roleId}"]`
            );

            checkboxes.forEach(cb => cb.checked = this.checked);
        });
    });

    // Auto update trạng thái "Chọn tất cả"
    document.querySelectorAll('.permission-checkbox').forEach(cb => {
        cb.addEventListener('change', function () {
            const roleId = this.dataset.role;
            const all = document.querySelectorAll(
                `.permission-checkbox[data-role="${roleId}"]`
            );
            const checked = document.querySelectorAll(
                `.permission-checkbox[data-role="${roleId}"]:checked`
            );

            const selectAll = document.querySelector(
                `.select-all[data-role="${roleId}"]`
            );

            selectAll.checked = all.length === checked.length;
        });
    });

});
</script>
@endpush

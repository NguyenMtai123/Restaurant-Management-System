@foreach($employees as $employee)
<div class="modal fade" id="editEmployeeModal-{{ $employee->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content shadow border-0">

            <!-- HEADER -->
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bx bx-edit"></i> Sửa nhân viên: {{ $employee->name }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- BODY -->
            <div class="modal-body">
                <form action="{{ route('admin.employees.update', $employee) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Avatar -->
                    <div class="d-flex justify-content-center mb-4">
                        <label for="avatar-edit-{{ $employee->id }}" class="position-relative" style="cursor:pointer;">
                            <img src="{{ $employee->avatar ? asset('images/avatars/'.$employee->avatar) : asset('images/avatars/default.png') }}"
                                id="avatarPreviewEdit{{ $employee->id }}"
                                class="rounded-circle border shadow-sm"
                                width="110" height="110">
                            <span class="position-absolute bottom-0 end-0 bg-primary text-white rounded-circle p-2">
                                <i class="bi bi-camera-fill"></i>
                            </span>
                        </label>

                        <input type="file"
                            name="avatar"
                            class="d-none avatar-input"
                            accept="image/*"
                            id="avatar-edit-{{ $employee->id }}"
                            data-preview="avatarPreviewEdit{{ $employee->id }}">
                    </div>

                    <!-- Name & Email -->
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Họ và tên</label>
                            <input type="text" name="name" class="form-control"
                                value="{{ $employee->name }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control"
                                value="{{ $employee->email }}" required>
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Mật khẩu mới</label>
                            <input type="password" name="password" class="form-control" placeholder="Để trống nếu không đổi">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Xác nhận mật khẩu</label>
                            <input type="password" name="password_confirmation" class="form-control">
                        </div>
                    </div>

                    <!-- Phone & Role & Status -->
                    <div class="row g-3 mb-3">
                        <div class="col-md-4">
                            <label class="form-label">Số điện thoại</label>
                            <input type="text" name="phone" class="form-control" value="{{ $employee->phone }}">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Bộ phận</label>
                            <select name="role" class="form-select" required>
                                <option value="admin" {{ $employee->role=='admin'?'selected':'' }}>Admin</option>
                                <option value="staff" {{ $employee->role=='staff'?'selected':'' }}>Nhân viên</option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Trạng thái</label>
                            <select name="status" class="form-select" required>
                                <option value="active" {{ $employee->status=='active'?'selected':'' }}>Hoạt động</option>
                                <option value="inactive" {{ $employee->status=='inactive'?'selected':'' }}>Ngưng hoạt động</option>
                                <option value="banned" {{ $employee->status=='banned'?'selected':'' }}>Bị khóa</option>
                            </select>
                        </div>
                    </div>

                    <!-- Address -->
                    <div class="mb-4">
                        <label class="form-label">Địa chỉ</label>
                        <input type="text" name="address" class="form-control" value="{{ $employee->address }}">
                    </div>

                    <div class="text-end">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-save me-1"></i> Cập nhật
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endforeach

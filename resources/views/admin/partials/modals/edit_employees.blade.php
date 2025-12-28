@foreach($employees as $employee)
<div class="modal fade" id="editEmployeeModal-{{ $employee->id }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content shadow border-0">

            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bx bx-edit"></i> Sửa nhân viên: {{ $employee->name }}
                </h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ route('admin.employees.update', $employee->id) }}"
                  method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="modal-body">

                    <!-- AVATAR -->
                    <div class="text-center mb-4">
                        <label for="avatar-edit-{{ $employee->id }}" style="cursor:pointer;">
                            <img src="{{ $employee->avatar
                                ? asset('images/avatars/'.$employee->avatar)
                                : asset('images/avatars/default.png') }}"
                                id="avatarPreviewEdit{{ $employee->id }}"
                                class="rounded-circle border shadow-sm"
                                width="110" height="110">
                            <div class="small text-muted mt-1">Nhấn để đổi ảnh</div>
                        </label>
                        <input type="file"
                               name="avatar"
                               id="avatar-edit-{{ $employee->id }}"
                               class="d-none avatar-input"
                               data-preview="avatarPreviewEdit{{ $employee->id }}"
                               accept="image/*">
                    </div>

                    <!-- NAME & EMAIL -->
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Tên nhân viên</label>
                            <input type="text" name="name" class="form-control"
                                   value="{{ $employee->name }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control"
                                   value="{{ $employee->email }}" required>
                        </div>
                    </div>

                    <!-- PASSWORD -->
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Mật khẩu mới</label>
                            <input type="password" name="password" class="form-control"
                                   placeholder="Để trống nếu không đổi">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Xác nhận mật khẩu</label>
                            <input type="password" name="password_confirmation" class="form-control">
                        </div>
                    </div>

                    <!-- PHONE / ROLE / STATUS -->
                    <div class="row g-3 mb-3">
                        <div class="col-md-4">
                            <label class="form-label">SĐT</label>
                            <input type="text" name="phone" class="form-control"
                                   value="{{ $employee->phone }}">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Bộ phận</label>
                            <select name="role" class="form-select" required>
                                @foreach($roles as $role)
                                    <option value="{{ $role->name }}"
                                        {{ $employee->role_id == $role->id ? 'selected' : '' }}>
                                        {{ $role->label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Trạng thái</label>
                            <select name="status" class="form-select" required>
                                <option value="active" {{ $employee->status=='active'?'selected':'' }}>Hoạt động</option>
                                <option value="inactive" {{ $employee->status=='inactive'?'selected':'' }}>Ngưng</option>
                                <option value="banned" {{ $employee->status=='banned'?'selected':'' }}>Bị khóa</option>
                            </select>
                        </div>
                    </div>

                    <!-- ADDRESS -->
                    <div class="mb-3">
                        <label class="form-label">Địa chỉ</label>
                        <input type="text" name="address" class="form-control"
                               value="{{ $employee->address }}">
                    </div>

                </div>

                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bx bx-save"></i> Cập nhật
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

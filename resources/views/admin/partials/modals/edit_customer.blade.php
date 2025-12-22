@foreach($users as $user)
<!-- Modal Edit Customer -->
<div class="modal fade" id="editCustomerModal-{{ $user->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content shadow border-0">

            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bx bx-edit"></i> Sửa khách hàng: {{ $user->name }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <form action="{{ route('admin.users.update', $user) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Avatar -->
                    <div class="d-flex justify-content-center mb-4">
                        <label for="avatar-edit-{{ $user->id }}" class="position-relative" style="cursor:pointer;">
                            <img
                                src="{{ old('avatar', $user->avatar ? asset('images/avatars/'.$user->avatar) : asset('images/avatars/default.png')) }}"
                                id="avatarPreviewEdit{{ $user->id }}"
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
                               id="avatar-edit-{{ $user->id }}"
                               data-preview="avatarPreviewEdit{{ $user->id }}">
                        @error('avatar') <small class="text-danger d-block">{{ $message }}</small> @enderror
                    </div>

                    <!-- Name & Email -->
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Tên khách hàng</label>
                            <input type="text" name="name" class="form-control"
                                   value="{{ old('name', $user->name) }}" required>
                            @error('name') <small class="text-danger d-block">{{ $message }}</small> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control"
                                   value="{{ old('email', $user->email) }}" required>
                            @error('email') <small class="text-danger d-block">{{ $message }}</small> @enderror
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Mật khẩu mới</label>
                            <input type="password" name="password" class="form-control"
                                   placeholder="Để trống nếu không đổi">
                            @error('password') <small class="text-danger d-block">{{ $message }}</small> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Xác nhận mật khẩu</label>
                            <input type="password" name="password_confirmation" class="form-control">
                        </div>
                    </div>

                    <!-- Phone & Status -->
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Số điện thoại</label>
                            <input type="text" name="phone" class="form-control"
                                   value="{{ old('phone', $user->phone) }}">
                            @error('phone') <small class="text-danger d-block">{{ $message }}</small> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Trạng thái</label>
                            <select name="status" class="form-select" required>
                                <option value="active" {{ old('status', $user->status)=='active'?'selected':'' }}>Hoạt động</option>
                                <option value="inactive" {{ old('status', $user->status)=='inactive'?'selected':'' }}>Ngưng hoạt động</option>
                                <option value="banned" {{ old('status', $user->status)=='banned'?'selected':'' }}>Bị khóa</option>
                            </select>
                            @error('status') <small class="text-danger d-block">{{ $message }}</small> @enderror
                        </div>
                    </div>

                    <!-- Address -->
                    <div class="mb-4">
                        <label class="form-label">Địa chỉ</label>
                        <input type="text" name="address" class="form-control"
                               value="{{ old('address', $user->address) }}">
                        @error('address') <small class="text-danger d-block">{{ $message }}</small> @enderror
                    </div>

                    <input type="hidden" name="role" value="customer">

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

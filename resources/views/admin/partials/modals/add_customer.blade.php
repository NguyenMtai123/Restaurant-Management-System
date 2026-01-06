<!-- Modal Add Customer -->
<div class="modal fade" id="addCustomerModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">
                    <i class='bx bx-user-plus me-1'></i> Thêm khách hàng
                </h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">

                    <!-- AVATAR -->
                    <div class="text-center mb-4">
                        <label for="avatar-create" style="cursor:pointer;">
                            <img src="{{ old('avatar') ? asset('images/avatars/'.old('avatar')) : asset('images/avatars/default.png') }}"
                                 id="avatarPreviewCreate"
                                 class="rounded-circle border shadow-sm"
                                 width="110" height="110">
                            <div class="small text-muted mt-1">Nhấn để chọn ảnh</div>
                        </label>
                        <input type="file" name="avatar"
                               id="avatar-create"
                               class="d-none avatar-input"
                               data-preview="avatarPreviewCreate"
                               accept="image/*">
                        @error('avatar') <small class="text-danger d-block">{{ $message }}</small> @enderror
                    </div>

                    <!-- NAME & EMAIL -->
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Tên khách hàng</label>
                            <input type="text" name="name" class="form-control" placeholder="Nhập Tên" value="{{ old('name') }}">
                            @error('name') <small class="text-danger d-block">{{ $message }}</small> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" placeholder="Nhập Email" value="{{ old('email') }}">
                            @error('email') <small class="text-danger d-block">{{ $message }}</small> @enderror
                        </div>
                    </div>

                    <!-- PASSWORD -->
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Mật khẩu</label>
                            <input type="password" name="password" class="form-control" placeholder="Nhập mật khẩu">
                            @error('password') <small class="text-danger d-block">{{ $message }}</small> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Xác nhận mật khẩu</label>
                            <input type="password" name="password_confirmation" class="form-control" placeholder="Xác nhận mật khẩu">
                        </div>
                    </div>

                    <!-- PHONE & STATUS -->
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Số điện thoại</label>
                            <input type="text" name="phone" class="form-control" placeholder="Nhập SĐT" value="{{ old('phone') }}">
                            @error('phone') <small class="text-danger d-block">{{ $message }}</small> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Trạng thái</label>
                            <select name="status" class="form-select">
                                <option value="active" {{ old('status')=='active' ? 'selected' : '' }}>Hoạt động</option>
                                <option value="inactive" {{ old('status')=='inactive' ? 'selected' : '' }}>Ngưng hoạt động</option>
                                <option value="banned" {{ old('status')=='banned' ? 'selected' : '' }}>Bị khóa</option>
                            </select>
                            @error('status') <small class="text-danger d-block">{{ $message }}</small> @enderror
                        </div>
                    </div>

                    <!-- ADDRESS -->
                    <div>
                        <label class="form-label">Địa chỉ</label>
                        <input type="text" name="address" class="form-control" placeholder="Nhập địa chỉ" value="{{ old('address') }}">
                        @error('address') <small class="text-danger d-block">{{ $message }}</small> @enderror
                    </div>

                </div>

                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-primary text-white">
                        <i class='bx bx-save me-1'></i> Lưu khách hàng
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', () => {
    @if($errors->any())
        var addModal = new bootstrap.Modal(document.getElementById('addCustomerModal'));
        addModal.show();

        // Alert đỏ + tự động 3 giây
        let alertBox = document.createElement('div');
        alertBox.className = 'alert alert-danger position-fixed top-0 start-50 translate-middle-x mt-3 shadow';
        alertBox.style.zIndex = 1055;
        alertBox.innerHTML = 'Có lỗi xảy ra! Vui lòng kiểm tra thông tin.';
        document.body.appendChild(alertBox);
        setTimeout(() => { alertBox.remove(); }, 3000);
    @endif

});
</script>

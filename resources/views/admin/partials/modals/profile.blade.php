@php $admin = Auth::user(); @endphp

<div class="modal fade" id="profileModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content rounded-4 shadow-lg border-0">

            <div class="modal-header bg-light border-0">
                <h5 class="fw-bold mb-0">Hồ sơ cá nhân</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body p-0">
                <div class="row g-0">

                    {{-- CỘT TRÁI --}}
                    <div class="col-md-4 bg-light border-end d-flex flex-column align-items-center text-center p-4">

                        <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data" id="profileForm">
                            @csrf
                            @method('PUT')

                            {{-- AVATAR --}}
                            <div class="position-relative d-inline-block mb-3">
                                <img id="modalAvatarPreview"
                                     src="{{ $admin->avatar
                                        ? asset('images/avatars/'.$admin->avatar)
                                        : 'https://ui-avatars.com/api/?name='.urlencode($admin->name).'&background=ff6b35&color=fff' }}"
                                     class="rounded-circle shadow"
                                     style="width:110px;height:110px;object-fit:cover;border:4px solid #fff">

                                <label for="avatarInput"
                                       class="position-absolute bottom-0 end-0 bg-white rounded-circle shadow d-flex align-items-center justify-content-center"
                                       style="width:34px;height:34px;cursor:pointer">
                                    <i class="bx bx-camera text-primary"></i>
                                </label>

                                <input type="file"
                                       id="avatarInput"
                                       name="avatar"
                                       hidden
                                       accept="image/*"
                                       onchange="previewModalAvatar(this)">
                            </div>

                            <h6 class="fw-bold">{{ $admin->name }}</h6>
                            <span class="badge bg-primary-subtle text-primary mb-3">
                                {{ ucfirst($admin->role->name ?? 'admin') }}
                            </span>


                             {{-- THAM GIA & HOẠT ĐỘNG --}}
                            <div class="w-100 mt-auto">
                                @php $joined = $admin->created_at->diffForHumans(null, true); @endphp
                                <div class="d-flex justify-content-between w-100 px-3 py-2 border-top border-bottom bg-white mb-3">
                                    <div class="text-center">
                                        <small class="d-block text-muted" style="font-size: 11px;">THAM GIA</small>
                                        <span class="fw-bold text-dark">{{ $joined }}</span>
                                    </div>
                                    <div class="text-center">
                                        <small class="d-block text-muted" style="font-size: 11px;">HOẠT ĐỘNG</small>
                                        <span class="fw-bold text-success">Online</span>
                                    </div>
                                </div>

                                <div class="w-100 text-start small text-muted">
                                    <p class="mb-1"><i class='bx bx-envelope me-2'></i> {{ $admin->email }}</p>
                                    <p class="mb-0"><i class='bx bx-phone me-2'></i> {{ $admin->phone ?? '-' }}</p>
                                    <p class="mb-0"><i class='bx bx-map me-2'></i> {{ $admin->address ?? '-' }}</p>
                                </div>
                            </div>
                        </form>
                    </div>

                    {{-- CỘT PHẢI --}}
                    <div class="col-md-8">
                        <div class="p-3 border-bottom">
                            <ul class="nav nav-pills nav-fill small fw-bold">
                                <li class="nav-item">
                                    <button class="nav-link active rounded-pill" data-bs-toggle="tab" data-bs-target="#infoTab">Thông tin</button>
                                </li>
                                <li class="nav-item">
                                    <button class="nav-link rounded-pill" data-bs-toggle="tab" data-bs-target="#securityTab">Bảo mật</button>
                                </li>
                            </ul>
                        </div>

                        <div class="tab-content p-4" style="height:350px; overflow-y:auto">

                            {{-- THÔNG TIN --}}
                            <div class="tab-pane fade show active" id="infoTab">
                                <div class="mb-3">
                                    <label class="form-label small">Tên hiển thị</label>
                                    <input type="text" form="profileForm" name="name" class="form-control form-control-sm" value="{{ $admin->name }}">
                                </div>

                                <div class="row g-2 mb-3">
                                    <div class="col-6">
                                        <label class="form-label small">Email</label>
                                        <input type="email" form="profileForm" name="email" class="form-control form-control-sm" value="{{ $admin->email }}">
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label small">SĐT</label>
                                        <input type="text" form="profileForm" name="phone" class="form-control form-control-sm" value="{{ $admin->phone }}">
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label small">Địa chỉ</label>
                                    <input type="text" form="profileForm" name="address" class="form-control form-control-sm" value="{{ $admin->address }}">
                                </div>

                                <div class="text-end">
                                    <button type="submit" form="profileForm" class="btn btn-primary btn-sm px-4">
                                        Lưu thay đổi
                                    </button>
                                </div>
                            </div>

                            {{-- BẢO MẬT --}}
                            <div class="tab-pane fade" id="securityTab">
                                <form action="{{ route('admin.profile.password') }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <div class="mb-2">
                                        <label class="small">Mật khẩu cũ</label>
                                        <input type="password" name="current_password" class="form-control form-control-sm">
                                    </div>

                                    <div class="mb-2">
                                        <label class="small">Mật khẩu mới</label>
                                        <input type="password" name="password" class="form-control form-control-sm">
                                    </div>

                                    <div class="mb-3">
                                        <label class="small">Xác nhận mật khẩu</label>
                                        <input type="password" name="password_confirmation" class="form-control form-control-sm">
                                    </div>

                                    <div class="text-end">
                                        <button class="btn btn-danger btn-sm px-4">Đổi mật khẩu</button>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<script>
function previewModalAvatar(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            document.getElementById('modalAvatarPreview').src = e.target.result;
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>

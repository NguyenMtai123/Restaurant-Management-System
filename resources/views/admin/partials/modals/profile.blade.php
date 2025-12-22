@php $admin = Auth::user(); @endphp

<div class="modal fade" id="profileModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-0 pe-4 pt-4 bg-light">
                <h5 class="modal-title fw-bold">Hồ sơ cá nhân</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body p-0">
                <div class="row g-0">
                    {{-- Cột trái --}}
                    <div class="col-md-4 bg-light border-end d-flex flex-column align-items-center text-center p-4">
                        <div class="position-relative mb-3">
                            <img src="{{ $admin->avatar ? asset('images/avatars/'.$admin->avatar) : 'https://ui-avatars.com/api/?name='.urlencode($admin->name).'&background=ff6b35&color=fff' }}"
                                 class="rounded-circle shadow-sm" style="width:100px;height:100px;border:3px solid #fff;" id="modalAvatarPreview" alt="Avatar">
                            <label class="position-absolute bottom-0 end-0 bg-white shadow-sm rounded-circle d-flex align-items-center justify-content-center text-primary"
                                   style="width:32px;height:32px;cursor:pointer;border:1px solid #eee;">
                                <i class='bx bx-camera'></i>
                                <input type="file" hidden onchange="previewModalAvatar(this)" id="avatarInput" name="avatar">
                            </label>
                        </div>

                        <h6 class="fw-bold mb-1">{{ $admin->name }}</h6>
                        <span class="badge bg-primary-subtle text-primary mb-3">{{ ucfirst($admin->role) }}</span>

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
                        </div>

                    {{-- Cột phải --}}
                    <div class="col-md-8 bg-white">
                        <div class="p-3 border-bottom">
                            <ul class="nav nav-pills nav-fill small fw-bold" role="tablist">
                                <li class="nav-item">
                                    <button class="nav-link active rounded-pill" data-bs-toggle="tab" data-bs-target="#m-info">Thông tin</button>
                                </li>
                                <li class="nav-item">
                                    <button class="nav-link rounded-pill" data-bs-toggle="tab" data-bs-target="#m-security">Bảo mật</button>
                                </li>
                            </ul>
                        </div>

                        <div class="tab-content p-4" style="height:350px; overflow-y:auto;">
                            {{-- Thông tin --}}
                            <div class="tab-pane fade show active" id="m-info">
                                <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="mb-3">
                                        <label class="form-label small text-muted">Tên hiển thị</label>
                                        <input type="text" name="name" class="form-control form-control-sm" value="{{ $admin->name }}">
                                    </div>
                                    <div class="row g-2 mb-3">
                                        <div class="col-6">
                                            <label class="form-label small text-muted">Email</label>
                                            <input type="email" name="email" class="form-control form-control-sm" value="{{ $admin->email }}">
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label small text-muted">Số điện thoại</label>
                                            <input type="tel" name="phone" class="form-control form-control-sm" value="{{ $admin->phone }}">
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label small text-muted">Địa chỉ</label>
                                        <input type="text" name="address" class="form-control form-control-sm" value="{{ $admin->address }}">
                                    </div>
                                    <div class="text-end">
                                        <button type="submit" class="btn btn-primary btn-sm px-3">Lưu thay đổi</button>
                                    </div>
                                </form>
                            </div>

                            {{-- Bảo mật --}}
                            <div class="tab-pane fade" id="m-security">
                                <form action="{{ route('admin.profile.password') }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="mb-2">
                                        <label class="form-label small text-muted">Mật khẩu cũ</label>
                                        <input type="password" name="current_password" class="form-control form-control-sm">
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label small text-muted">Mật khẩu mới</label>
                                        <input type="password" name="password" class="form-control form-control-sm">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label small text-muted">Xác nhận mật khẩu</label>
                                        <input type="password" name="password_confirmation" class="form-control form-control-sm">
                                    </div>
                                    <div class="alert alert-warning py-2 small border-0 bg-warning-subtle text-warning-emphasis">
                                        <i class='bx bx-lock-alt'></i> Mật khẩu cần có ít nhất 6 ký tự.
                                    </div>
                                    <div class="text-end">
                                        <button type="submit" class="btn btn-danger btn-sm px-3">Đổi mật khẩu</button>
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

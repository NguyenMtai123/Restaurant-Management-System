<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý người dùng</title>

    <!-- Bootstrap CSS + Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>👥 Quản lý người dùng</h2>
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createUserModal">
            <i class="bi bi-plus-circle me-1"></i> Thêm user
        </button>
    </div>

    <!-- ALERT -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- TABLE -->
    <div class="card shadow-sm rounded-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle mb-0">
                    <thead class="table-light text-center">
                        <tr>
                            <th>ID</th>
                            <th>Avatar</th>
                            <th class="text-start">Tên</th>
                            <th>Email</th>
                            <th>Điện thoại</th>
                            <th class="text-start">Địa chỉ</th>
                            <th>Role</th>
                            <th>Trạng thái</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                        <tr class="text-center">
                            <td>{{ $user->id }}</td>
                            <td>
                                <img src="{{ $user->avatar ? asset('images/avatars/' . $user->avatar) : asset('images/avatars/default.png') }}"
                                     class="rounded-circle" width="50" height="50" alt="Avatar">
                            </td>
                            <td class="text-start">{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->phone ?? '-' }}</td>
                            <td class="text-start">{{ $user->address ?? '-' }}</td>
                            <td>
                                <span class="badge bg-primary">{{ ucfirst($user->role) }}</span>
                            </td>
                            <td>
                                @if($user->status === 'active')
                                    <span class="badge bg-success">Active</span>
                                @elseif($user->status === 'inactive')
                                    <span class="badge bg-secondary">Inactive</span>
                                @else
                                    <span class="badge bg-danger">Banned</span>
                                @endif
                            </td>
                            <td>
                                <!-- Edit button -->
                                <button class="btn btn-primary btn-sm me-1" data-bs-toggle="modal" data-bs-target="#editUserModal-{{ $user->id }}">
                                    <i class="bi bi-pencil-square"></i>
                                </button>

                                <!-- Delete button -->
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline" onsubmit="return confirm('Xác nhận xóa?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>

                        <!-- Modal Edit -->
                        <div class="modal fade" id="editUserModal-{{ $user->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Sửa user: {{ $user->name }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('admin.users.update', $user) }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')

                                            <!-- Avatar -->
                                            <div class="d-flex justify-content-center mb-3">
                                                <label for="avatar-{{ $user->id }}" class="position-relative" style="cursor:pointer;">
                                                    <img src="{{ $user->avatar ? asset('images/avatars/'.$user->avatar) : asset('images/avatars/default.png') }}"
                                                        id="avatarPreview{{ $user->id }}" class="rounded-circle border" width="100" height="100" alt="Avatar">
                                                    <span class="position-absolute bottom-0 end-0 bg-primary text-white rounded-circle p-1">
                                                        <i class="bi bi-camera-fill"></i>
                                                    </span>
                                                </label>
                                                <input type="file" name="avatar" class="d-none avatar-input" accept="image/*"
                                                    id="avatar-{{ $user->id }}" data-preview="avatarPreview{{ $user->id }}">

                                            </div>

                                            <!-- Name & Email -->
                                            <div class="row mb-3">
                                                <div class="col">
                                                    <label class="form-label">Tên</label>
                                                    <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
                                                </div>
                                                <div class="col">
                                                    <label class="form-label">Email</label>
                                                    <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
                                                </div>
                                            </div>

                                            <!-- Password & Confirm -->
                                            <div class="row mb-3">
                                                <div class="col">
                                                    <label class="form-label">Mật khẩu (để trống nếu không đổi)</label>
                                                    <input type="password" name="password" class="form-control">
                                                </div>
                                                <div class="col">
                                                    <label class="form-label">Xác nhận mật khẩu</label>
                                                    <input type="password" name="password_confirmation" class="form-control">
                                                </div>
                                            </div>

                                            <!-- Phone, Role, Status -->
                                            <div class="row mb-3">
                                                <div class="col">
                                                    <label class="form-label">Điện thoại</label>
                                                    <input type="text" name="phone" class="form-control" value="{{ $user->phone }}">
                                                </div>
                                                <div class="col">
                                                    <label class="form-label">Role</label>
                                                    <select name="role" class="form-select" required>
                                                        <option value="customer" {{ $user->role=='customer'?'selected':'' }}>Customer</option>
                                                        <option value="staff" {{ $user->role=='staff'?'selected':'' }}>Staff</option>
                                                        <option value="admin" {{ $user->role=='admin'?'selected':'' }}>Admin</option>
                                                    </select>
                                                </div>
                                                <div class="col">
                                                    <label class="form-label">Trạng thái</label>
                                                    <select name="status" class="form-select" required>
                                                        <option value="active" {{ $user->status=='active'?'selected':'' }}>Active</option>
                                                        <option value="inactive" {{ $user->status=='inactive'?'selected':'' }}>Inactive</option>
                                                        <option value="banned" {{ $user->status=='banned'?'selected':'' }}>Banned</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- Address -->
                                            <div class="mb-3">
                                                <label class="form-label">Địa chỉ</label>
                                                <input type="text" name="address" class="form-control" value="{{ $user->address }}">
                                            </div>

                                            <div class="text-end">
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="bi bi-save me-1"></i> Cập nhật
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted">Chưa có user nào</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<!-- Modal Create -->
<div class="modal fade" id="createUserModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Thêm user mới</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Avatar -->
                    <div class="d-flex justify-content-center mb-3">
                        <label for="avatar-create" class="position-relative" style="cursor:pointer;">
                            <img src="{{ asset('images/avatars/default.png') }}" id="avatarPreviewCreate" class="rounded-circle border" width="100" height="100" alt="Avatar">
                            <span class="position-absolute bottom-0 end-0 bg-primary text-white rounded-circle p-1">
                                <i class="bi bi-camera-fill"></i>
                            </span>
                        </label>
                    <input type="file" name="avatar" class="d-none avatar-input" accept="image/*"
                         id="avatar-create" data-preview="avatarPreviewCreate">
                    </div>

                    <!-- Name & Email -->
                    <div class="row mb-3">
                        <div class="col">
                            <label class="form-label">Tên</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="col">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                    </div>

                    <!-- Password & Confirm -->
                    <div class="row mb-3">
                        <div class="col">
                            <label class="form-label">Mật khẩu</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="col">
                            <label class="form-label">Xác nhận mật khẩu</label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>
                    </div>

                    <!-- Phone, Role, Status -->
                    <div class="row mb-3">
                        <div class="col">
                            <label class="form-label">Điện thoại</label>
                            <input type="text" name="phone" class="form-control">
                        </div>
                        <div class="col">
                            <label class="form-label">Role</label>
                            <select name="role" class="form-select" required>
                                <option value="customer">Customer</option>
                                <option value="staff">Staff</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>
                        <div class="col">
                            <label class="form-label">Trạng thái</label>
                            <select name="status" class="form-select" required>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                                <option value="banned">Banned</option>
                            </select>
                        </div>
                    </div>

                    <!-- Address -->
                    <div class="mb-3">
                        <label class="form-label">Địa chỉ</label>
                        <input type="text" name="address" class="form-control">
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-save me-1"></i> Thêm
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // tất cả input file có class .avatar-input
    document.querySelectorAll('.avatar-input').forEach(function(input) {
        input.addEventListener('change', function() {
            if(this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    // lấy id từ data-preview attribute
                    const previewId = this.getAttribute('data-preview');
                    document.getElementById(previewId).src = e.target.result;
                }
                reader.readAsDataURL(this.files[0]);
            }
        });
    });
});
</script>


<div class="container">
    <h2>Chỉnh sửa người dùng: {{ $user->name }}</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>@foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach</ul>
        </div>
    @endif

    <form action="{{ route('users.update', $user) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Tên</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
        </div>

        <div class="mb-3">
            <label>Mật khẩu mới (không bắt buộc)</label>
            <input type="password" name="password" class="form-control">
        </div>

        <div class="mb-3">
            <label>Xác nhận mật khẩu</label>
            <input type="password" name="password_confirmation" class="form-control">
        </div>

        <div class="mb-3">
            <label>Điện thoại</label>
            <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}">
        </div>

        <div class="mb-3">
            <label>Địa chỉ</label>
            <input type="text" name="address" class="form-control" value="{{ old('address', $user->address) }}">
        </div>

        <div class="mb-3">
            <label>Avatar hiện tại</label>
            <td>
                @if($user->avatar)
                    <img src="{{ asset('images/avatars/' . $user->avatar) }}" width="50" alt="Avatar">
                @else
                    <img src="{{ asset('images/avatars/default.png') }}" width="50" alt="Avatar">
                @endif
            </td>

            <label>Thay avatar</label>
            <input type="file" name="avatar" class="form-control">
        </div>

        <div class="mb-3">
            <label>Role</label>
            <select name="role" class="form-select">
                <option value="customer" {{ $user->role=='customer'?'selected':'' }}>Customer</option>
                <option value="staff" {{ $user->role=='staff'?'selected':'' }}>Staff</option>
                <option value="admin" {{ $user->role=='admin'?'selected':'' }}>Admin</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Trạng thái</label>
            <select name="status" class="form-select">
                <option value="active" {{ $user->status=='active'?'selected':'' }}>Active</option>
                <option value="inactive" {{ $user->status=='inactive'?'selected':'' }}>Inactive</option>
                <option value="banned" {{ $user->status=='banned'?'selected':'' }}>Banned</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Cập nhật</button>
        <a href="{{ route('users.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
</div>

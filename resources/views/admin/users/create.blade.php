
<div class="container">
    <h2>Thêm người dùng mới</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>@foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach</ul>
        </div>
    @endif

    <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label>Tên</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
        </div>

        <div class="mb-3">
            <label>Mật khẩu</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Xác nhận mật khẩu</label>
            <input type="password" name="password_confirmation" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Điện thoại</label>
            <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
        </div>

        <div class="mb-3">
            <label>Địa chỉ</label>
            <input type="text" name="address" class="form-control" value="{{ old('address') }}">
        </div>

        <div class="mb-3">
            <label>Avatar</label>
            <input type="file" name="avatar" class="form-control">
        </div>

        <div class="mb-3">
            <label>Role</label>
            <select name="role" class="form-select">
                <option value="customer" {{ old('role')=='customer'?'selected':'' }}>Customer</option>
                <option value="staff" {{ old('role')=='staff'?'selected':'' }}>Staff</option>
                <option value="admin" {{ old('role')=='admin'?'selected':'' }}>Admin</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Trạng thái</label>
            <select name="status" class="form-select">
                <option value="active" {{ old('status')=='active'?'selected':'' }}>Active</option>
                <option value="inactive" {{ old('status')=='inactive'?'selected':'' }}>Inactive</option>
                <option value="banned" {{ old('status')=='banned'?'selected':'' }}>Banned</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Thêm</button>
        <a href="{{ route('users.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
</div>

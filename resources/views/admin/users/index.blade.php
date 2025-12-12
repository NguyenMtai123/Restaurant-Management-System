<div class="container">
    <h2>Quản lý người dùng</h2>

    <a href="{{ route('users.create') }}" class="btn btn-success mb-3">Thêm user mới</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Avatar</th>
                <th>Tên</th>
                <th>Email</th>
                <th>Điện thoại</th>
                <th>Địa chỉ</th>
                <th>Role</th>
                <th>Trạng thái</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
               <td>
                    @if($user->avatar)
                        <img src="{{ asset('images/avatars/' . $user->avatar) }}" width="50" alt="Avatar">
                    @else
                        <img src="{{ asset('images/avatars/default.png') }}" width="50" alt="Avatar">
                    @endif
                </td>

                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->phone }}</td>
                <td>{{ $user->address }}</td>
                <td>{{ $user->role }}</td>
                <td>{{ $user->status }}</td>
                <td>
                    <a href="{{ route('users.edit', $user) }}" class="btn btn-primary btn-sm">Sửa</a>
                    <form action="{{ route('users.destroy', $user) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Xác nhận xóa?')">Xóa</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

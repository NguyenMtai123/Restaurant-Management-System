@extends('layouts.auth')
@section('content')
<div class="login-form">
    <div class="logo">
        <img src="{{ asset('images/logo.jpg') }}" alt="Logo">
    </div>
    <h2>Đăng ký</h2>

    <form action="{{ route('register.post') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="input-group">
            <span class="material-icons icon-left">person</span>
            <input type="text" name="name" placeholder="Họ và tên" value="{{ old('name') }}" required>
            @error('name') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="input-group">
            <span class="material-icons icon-left">email</span>
            <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required>
            @error('email') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="input-group">
            <span class="material-icons icon-left">lock</span>
            <input type="password" name="password" placeholder="Mật khẩu" required>
            <span class="show-password" onclick="togglePassword(this)">
                <span class="material-icons">visibility_off</span>
            </span>
            @error('password') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="input-group">
            <span class="material-icons icon-left">lock</span>
            <input type="password" name="password_confirmation" placeholder="Xác nhận mật khẩu" required>
            <span class="show-password" onclick="togglePassword(this)">
                <span class="material-icons">visibility_off</span>
            </span>
            @error('password_confirmation') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="input-group">
            <span class="material-icons icon-left">phone</span>
            <input type="text" name="phone" placeholder="Số điện thoại" value="{{ old('phone') }}">
        </div>

        <div class="input-group">
            <span class="material-icons icon-left">home</span>
            <input type="text" name="address" placeholder="Địa chỉ" value="{{ old('address') }}">
        </div>

        <button type="submit">Đăng ký</button>

        <p class="register-link">
            Bạn đã có tài khoản? <a href="{{ route('login') }}">Đăng nhập</a>
        </p>
    </form>
</div>

<script>
function togglePassword(el){
    const input = el.previousElementSibling;
    const icon = el.querySelector('span');
    input.type = input.type === 'password' ? 'text' : 'password';
    icon.innerText = input.type === 'password' ? 'visibility_off' : 'visibility';
}
</script>
@endsection

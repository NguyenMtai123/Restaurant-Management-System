@extends('layouts.auth')
@section('content')
<div class="login-form">
    <div class="logo">
        <img src="{{ asset('images/logo.jpg') }}" alt="Logo">
    </div>
    <h2>Đăng nhập</h2>

    <form id="loginForm" action="{{ route('login.post') }}" method="POST">
        @csrf

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

        <div class="options">
            <label>
                <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}> Ghi nhớ mật khẩu
            </label>
            <a href="{{ route('password.request') }}">Quên mật khẩu?</a>
        </div>

        <button type="submit">Đăng nhập</button>
        <p class="register-link">Chưa có tài khoản? <a href="{{ route('register') }}">Đăng ký ngay</a></p>
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

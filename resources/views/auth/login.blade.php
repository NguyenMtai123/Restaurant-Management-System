@extends('layouts.auth')
@section('content')
        <div class="logo">
            <img src="{{ asset('images/logo.jpg') }}" alt="Logo">
        </div>
        <h2>Đăng nhập</h2>
        <form id="loginForm" action="{{ route('login.post') }}" method="POST">
            @csrf
            <div class="input-group">
                <span class="material-icons icon-left">email</span>
                <input type="email" name="email" placeholder="Email" required>
            </div>

            <div class="input-group">
                <span class="material-icons icon-left">lock</span>
                <input type="password" name="password" placeholder="Mật khẩu" required>
                <span class="show-password" onclick="togglePassword(this)">
                    <span class="material-icons" id="eyeIcon">visibility_off</span>
                </span>
                @error('password') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="options">
                <label><input type="checkbox" id="remember"> Ghi nhớ mật khẩu</label>
                <a href="forgot-password.html">Quên mật khẩu?</a>
            </div>

            <button type="submit">Login</button>
            <p class="register-link">Chưa có tài khoản? <a href="{{ route('register') }}">Đăng ký ngay</a></p>
        </form>
    </div>
@endsection
<script>
function togglePassword(el){
    const input = el.previousElementSibling;
    const icon = el.querySelector('span');
    if(input.type === 'password'){
        input.type = 'text';
        icon.innerText = 'visibility';
    } else {
        input.type = 'password';
        icon.innerText = 'visibility_off';
    }
}
</script>

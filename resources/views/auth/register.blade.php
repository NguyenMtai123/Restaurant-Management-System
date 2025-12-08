@extends('layouts.auth')
@section('content')
    {{-- Form đăng ký --}}
    <div class="logo">
            <img src="{{ asset('images/logo.jpg') }}" alt="Logo">
        </div>
        <h2>Đăng ký</h2>
        <form action="{{ route('register.post') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="input-group">
                <span class="material-icons icon-left">person</span>
                <input type="text" name="name" placeholder="Họ và tên" required>
                @error('name') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="input-group">
                <span class="material-icons icon-left">email</span>
                <input type="email" name="email" placeholder="Email" required>
                @error('email') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="input-group">
                <span class="material-icons icon-left">lock</span>
                <input type="password" name="password" placeholder="Mật khẩu" required>
                <span class="show-password" onclick="togglePassword(this)">
                    <span class="material-icons" id="eyeIcon">visibility_off</span>
                </span>
                @error('password') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="input-group">
                <span class="material-icons icon-left">lock</span>
                <input type="password" name="password_confirmation" placeholder="Xác nhận mật khẩu" required>
            </div>

            <div class="input-group">
                <span class="material-icons icon-left">phone</span>
                <input type="text" name="phone" placeholder="Số điện thoại">
            </div>

            <div class="input-group">
                <span class="material-icons icon-left">home</span>
                <input type="text" name="address" placeholder="Địa chỉ">
            </div>
            <button type="submit">Đăng ký</button>
            <p class="register-link">
                Bạn đã có tài khoản? <a href="{{ route('login') }}">Đăng nhập</a>
            </p>
        </form>

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
@endsection

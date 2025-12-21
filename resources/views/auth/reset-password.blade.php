@extends('layouts.auth')
<style>
    .reset-container {
    max-width: 400px;
    margin: 50px auto;
    padding: 35px 25px;
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    text-align: center;
    font-family: 'Arial', sans-serif;
}

.reset-container .logo img {
    width: 80px;
    margin-bottom: 20px;
    border-radius: 50%;
}

.reset-container h2 {
    font-size: 24px;
    margin-bottom: 10px;
    color: #333;
}

.reset-container p {
    font-size: 14px;
    color: #666;
    margin-bottom: 20px;
}



.btn-submit {
    width: 100%;
    padding: 12px;
    background-color: #ff7300;
    color: #fff;
    border: none;
    font-size: 16px;
    border-radius: 8px;
    cursor: pointer;
    transition: 0.3s;
}

.btn-submit:hover {
    background-color: #b35400;
}

.alert {
    padding: 10px;
    margin-bottom: 15px;
    border-radius: 8px;
    font-size: 14px;
}

.alert-danger {
    background-color: #f8d7da;
    color: #842029;
    border: 1px solid #f5c2c7;
}

.back-login {
    margin-top: 15px;
    font-size: 14px;
}

.back-login a {
    color: #ec6009;
    text-decoration: none;
}

.back-login a:hover {
    text-decoration: underline;
}

</style>
@section('content')
<div class="reset-container">
    <div class="logo">
        <img src="{{ asset('images/logo.jpg') }}" alt="Logo">
    </div>

    <h2>Đặt lại mật khẩu</h2>
    <p>Nhập email và mật khẩu mới của bạn.</p>

    @if($errors->any())
        <div class="alert alert-danger">
            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form action="{{ route('password.update') }}" method="POST" class="reset-form">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">

        <div class="input-group">
            <span class="material-icons icon-left">email</span>
            <input type="email" name="email" placeholder="Email" required>
        </div>

        <div class="input-group">
            <span class="material-icons icon-left">lock</span>
            <input type="password" name="password" placeholder="Mật khẩu mới" required>
        </div>

        <div class="input-group">
            <span class="material-icons icon-left">lock</span>
            <input type="password" name="password_confirmation" placeholder="Nhập lại mật khẩu" required>
        </div>

        <button type="submit" class="btn-submit">Đặt lại mật khẩu</button>
    </form>

    <p class="back-login">
        <a href="{{ route('login') }}">← Quay lại đăng nhập</a>
    </p>
</div>
@endsection

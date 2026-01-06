@extends('layouts.auth')

@section('content')
    <div class="logo">
        <img src="{{ asset('images/logo.jpg') }}" alt="Logo">
    </div>
    <h2>Quên mật khẩu</h2>
    <p>Nhập email của bạn để nhận link đặt lại mật khẩu.</p>
    <br>
    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <form action="{{ route('password.email') }}" method="POST" class="forgot-form">
        @csrf
        <div class="input-group">
            <span class="material-icons icon-left">email</span>
            <input type="email" name="email" placeholder="Nhập email của bạn" required>
        </div>

        <button type="submit" class="btn-submit">Gửi link reset</button>
    </form>

    <p class="back-login">
        <a href="{{ route('login') }}">← Quay lại đăng nhập</a>
    </p>
@endsection

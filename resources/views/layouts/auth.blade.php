<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'FoodieHub')</title>
    <!-- CSS chính -->
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
    <!-- FontAwesome Icon -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<body>
<div class="auth-container">
    <div class="cover" style="background: url('{{ asset("images/banner-1.png") }}') center/cover no-repeat;">
        <h1>Welcome to Restaurant Management</h1>
        <p>Quản lý đơn hàng, bàn, nhân viên chuyên nghiệp.</p>
    </div>

    <!-- Nội dung bên phải -->
    <div class="login-form">
        {{-- <div class="logo">
            <img src="{{ asset('images/logo.jpg') }}" alt="Logo">
        </div>
        <h2>Đăng nhập</h2> --}}
        @yield('content')
    </div>
</div>

<!-- JS chung -->
@stack('scripts')
</body>
</html>

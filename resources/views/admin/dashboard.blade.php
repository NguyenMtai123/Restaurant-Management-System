<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dashboard</title>
</head>
<body>
   <h1>Admin Dashboard</h1>
    <p>Xin chào, {{ session('user.name') }}</p>
    <a href="{{ route('logout') }}">Đăng xuất</a>

</body>
</html>

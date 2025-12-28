<?php

namespace App\Http\Controllers\Web\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            "email" => "required|email",
            "password" => "required"
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Email không tồn tại'])->withInput();
        }

        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors(['password' => 'Mật khẩu không chính xác']);
        }

        // Đăng nhập thành công, ghi nhớ nếu tick checkbox
        Auth::login($user, $request->filled('remember'));

        $role = $user->role->name;

        return match ($role) {
            'admin' => redirect()->route('admin.dashboard'),
            'staff' => redirect()->route('admin.dashboard'), // staff dùng chung dashboard
            default => redirect()->route('home'),
        };

    }

    public function logout(Request $request)
    {
        Auth::logout();

        // 2. Xóa session cũ
        $request->session()->invalidate();

        // 3. Tạo lại CSRF token mới (bảo mật)
        $request->session()->regenerateToken();

        // 4. Xóa cookie "remember me" của Laravel
        \Cookie::queue(\Cookie::forget(Auth::getRecallerName()));

        return redirect()->route('login');
    }
}

<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthApiController extends Controller
{
     public function showLoginForm()
    {
        return view('auth.login');
    }
    public function login(LoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['error' => 'Email không tồn tại'], 404);
        }

        if ($user->status !== 'active') {
            return response()->json(['error' => 'Tài khoản đã bị khóa'], 403);
        }

        if (!Hash::check($request->password, $user->password)) {
            return response()->json(['error' => 'Mật khẩu không đúng'], 401);
        }
        Auth::login($user);
        // Lưu session
        session(['user' => [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role,
        ]]);
        return match($user->role) {
            'admin' => redirect()->route('admin.dashboard'),
            'staff' => redirect()->route('staff.dashboard'),
            'customer' => redirect()->route('customer.home'),
            default => redirect()->route('login')->withErrors(['role' => 'Vai trò không hợp lệ']),
        };


    }

    // API logout
    public function logout()
    {
        session()->forget('user');
        // return response()->json(['message' => 'Đã đăng xuất thành công']);
        return redirect()->route('login');
    }


}

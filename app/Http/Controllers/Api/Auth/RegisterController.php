<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use App\Http\Requests\RegisterUserRequest;

class RegisterController extends Controller
{
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(RegisterUserRequest $request)
    {
        $data = $request->validated();

        // Upload avatar nếu có
        if ($request->hasFile('avatar')) {
            $avatarName = time() . '_' . $request->file('avatar')->getClientOriginalName();
            $request->file('avatar')->move(public_path('images/avatars'), $avatarName);
            $data['avatar'] = $avatarName;
        }

        // Hash password
        $data['password'] = Hash::make($data['password']);

        $user = User::create($data);

        // Optionally: login tự động sau khi đăng ký
        Auth::login($user);
        switch ($user->role) {
            case 'admin':
                return redirect()->route('admin.dashboard')->with('success', 'Đăng ký thành công!');
            case 'staff':
                return redirect()->route('staff.dashboard')->with('success', 'Đăng ký thành công!');
            default:
                return redirect()->route('customer.home')->with('success', 'Đăng ký thành công!');

        }
    }
}

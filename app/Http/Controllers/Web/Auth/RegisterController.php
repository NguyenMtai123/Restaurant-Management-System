<?php

namespace App\Http\Controllers\Web\Auth;

use Carbon\Carbon;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\EmailVerification;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class RegisterController extends Controller
{
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            "name" => "required",
            "email" => "required|email|unique:users,email",
            "password" => "required|min:6|confirmed",
            "phone" => "nullable",
            "address" => "nullable"
        ]);

        // Tạo OTP 6 chữ số
        $otp = rand(100000, 999999);

        // Lưu thông tin đăng ký + OTP vào bảng tạm
        EmailVerification::updateOrCreate(
            ['email' => $request->email],
            [
                'name' => $request->name,
                'password' => Hash::make($request->password),
                'phone' => $request->phone,
                'address' => $request->address,
                'otp' => $otp,
                'expires_at' => Carbon::now()->addMinutes(10),
                'used' => false
            ]
        );

        // Gửi mail OTP
        Mail::raw("Mã OTP của bạn là: $otp. Hết hạn sau 10 phút.", function ($message) use ($request) {
            $message->to($request->email)
                    ->subject('Xác thực email đăng ký');
        });

        return redirect()->route('register.show-otp', ['email' => $request->email])
                         ->with('success', 'Mã OTP đã được gửi đến email của bạn.');
    }

    public function showOtpForm(Request $request)
    {
        $email = $request->email;
        return view('auth.verify-otp', compact('email'));
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp'   => 'required|digits:6'
        ]);

        $verification = EmailVerification::where('email', $request->email)
            ->where('otp', $request->otp)
            ->where('used', false)
            ->first();

        if (!$verification || $verification->isExpired()) {
            return back()->withErrors(['otp' => 'OTP không hợp lệ hoặc đã hết hạn']);
        }

        if (User::where('email', $verification->email)->exists()) {
            return redirect()->route('login')->withErrors([
                'email' => 'Email đã được đăng ký'
            ]);
        }

        $customerRole = Role::where('name', 'customer')->firstOrFail();

        $user = User::create([
            'name' => $verification->name,
            'email' => $verification->email,
            'password' => $verification->password,
            'phone' => $verification->phone,
            'address' => $verification->address,
            'status' => 'active',
            'role_id' => $customerRole->id,
            'email_verified_at' => Carbon::now(),
        ]);

        $verification->delete(); // gọn DB

        Auth::login($user);

        return redirect()->route('customer.home')
            ->with('success', 'Đăng ký thành công!');
    }
}

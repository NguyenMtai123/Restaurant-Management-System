<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class AuthApiController extends Controller
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

        $user = User::where("email", $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(["error" => "Sai email hoặc mật khẩu"], 401);
        }

        if ($user->status !== "active") {
            return response()->json(["error" => "Tài khoản bị khóa"], 403);
        }

        $token = $user->createToken("api_token")->plainTextToken;

        return response()->json([
            "message" => "Đăng nhập thành công",
            "token" => $token,
            "user" => $user,
            "role"  => $user->role->name,
        ], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(["message" => "Đăng xuất thành công"]);
    }


}

<?php

namespace App\Http\Controllers\Api\Auth;
use App\Models\Role;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterUserRequest;

class RegisterApiController extends Controller
{
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(RegisterUserRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('avatar')) {
            $avatarName = time().'_'.$request->file('avatar')->getClientOriginalName();
            $request->file('avatar')->move(public_path('images/avatars'), $avatarName);
            $data['avatar'] = $avatarName;
        }

        $customerRole = Role::where('name', 'customer')->firstOrFail();

        $data['role_id'] = $customerRole->id;
        $data['status'] = 'active';

        $user = User::create($data);

        $token = $user->createToken('api_token')->plainTextToken;

        return response()->json([
            'message' => 'Đăng ký thành công',
            'user' => $user,
            'role' => $user->role->name,
            'token' => $token,
        ], 201);
    }
}

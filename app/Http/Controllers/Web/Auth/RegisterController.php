<?php

namespace App\Http\Controllers\Web\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
           "email" => "required|email|unique:users",
           "password" => "required|min:6|confirmed"
        ]);

       $user = User::create([
            "name"     => $request->name,
            "email"    => $request->email,
            "password" => Hash::make($request->password),
            "phone"    => $request->phone ?? null,      // thêm dòng này
            "address"  => $request->address ?? null,    // thêm dòng này
        ]);


        Auth::login($user);

        return match($user->role) {
            'admin'   => redirect()->route('admin.dashboard'),
            'staff'   => redirect()->route('staff.dashboard'),
            default   => redirect()->route('customer.home'),
        };
    }
}

<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|max:20',
            'address' => 'nullable|max:255',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->only('name','email','phone','address');

        if ($request->hasFile('avatar')) {

            if ($user->avatar && file_exists(public_path($user->avatar))) {
                unlink(public_path($user->avatar));
            }

            $file = $request->file('avatar');
            $filename = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('images/avatars'), $filename);

            $data['avatar'] = $filename;
        }

        $user->update($data);

        return back()->with('success','Cập nhật hồ sơ thành công');
    }


    public function password(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password'=>'Mật khẩu cũ không đúng']);
        }

        $user->update(['password'=>Hash::make($request->password)]);

        return back()->with('success','Đổi mật khẩu thành công');
    }
}

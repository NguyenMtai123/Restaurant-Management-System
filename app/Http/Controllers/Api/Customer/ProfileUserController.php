<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileUserController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('customer.profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        // Validate dữ liệu
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'avatar' => 'nullable|image|max:2048',
        ]);

        // Xử lý avatar nếu có
        if($request->hasFile('avatar')){
            // Tạo tên file duy nhất
            $avatarName = time() . '_' . $request->file('avatar')->getClientOriginalName();
            // Move file vào public/images/avatars
            $request->file('avatar')->move(public_path('images/avatars'), $avatarName);
            $data['avatar'] = $avatarName;
        }

        // Cập nhật thông tin user
        $user->update($data);

        // Redirect về home sau khi update
        return redirect()->route('home')->with('success', 'Cập nhật thông tin thành công!');
    }
}

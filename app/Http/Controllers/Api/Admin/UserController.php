<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
     // Danh sách user
    public function index()
    {
        $users = User::latest()->get();
        return view('admin.users.index', compact('users'));
    }

    // Form thêm user
    public function create()
    {
        return view('admin.users.create');
    }

    // Lưu user mới
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'role' => 'required|in:customer,staff,admin',
            'status' => 'required|in:active,inactive,banned',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048', // kiểm tra file ảnh
        ]);

        $data = $request->only(['name','email','phone','address','role','status']);
        $data['password'] = Hash::make($request->password);

        // Upload avatar nếu có
        if ($request->hasFile('avatar')) {
            $avatarName = time() . '_' . $request->file('avatar')->getClientOriginalName();
            $request->file('avatar')->move(public_path('images/avatars'), $avatarName);
            $data['avatar'] = $avatarName;
        }

        User::create($data);

        return redirect()->route('users.index')->with('success', 'Thêm user thành công');
    }

    // Cập nhật user
        // Cập nhật user
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required','email', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:6|confirmed',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'role' => 'required|in:customer,staff,admin',
            'status' => 'required|in:active,inactive,banned',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048', // thêm validation avatar
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
            'phone' => $request->phone,
            'address' => $request->address,
            'role' => $request->role,
            'status' => $request->status,
        ];

        // Upload avatar nếu có
        if ($request->hasFile('avatar')) {
            $avatarName = time() . '_' . $request->file('avatar')->getClientOriginalName();
            $request->file('avatar')->move(public_path('images/avatars'), $avatarName);
            $data['avatar'] = $avatarName;

            // Optional: xóa avatar cũ nếu có
            if($user->avatar && file_exists(public_path('images/avatars/'.$user->avatar))){
                @unlink(public_path('images/avatars/'.$user->avatar));
            }
        }

        $user->update($data);

        return redirect()->route('users.index')->with('success', 'Cập nhật user thành công');
    }


    // Xóa user
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'Xóa user thành công');
    }
}

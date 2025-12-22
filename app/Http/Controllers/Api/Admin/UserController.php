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
    public function index(Request $request)
    {
        $query = User::withCount('orders')
            ->withSum('orders', 'total_amount')
            ->where('role', 'customer');

        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', "%{$keyword}%")
                ->orWhere('email', 'like', "%{$keyword}%")
                ->orWhere('phone', 'like', "%{$keyword}%");
            });
        }

        $sort = $request->get('sort', 'date_desc');

        match ($sort) {
            'name_asc'  => $query->orderBy('name', 'asc'),
            'name_desc' => $query->orderBy('name', 'desc'),
            'date_asc'  => $query->orderBy('created_at', 'asc'),
            default     => $query->orderBy('created_at', 'desc'),
        };

        $users = $query->paginate(10)->withQueryString();

        return view('admin.users.index', compact('users'));
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
            // 'role' => 'required|in:customer,staff,admin',
            'status' => 'required|in:active,inactive,banned',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048', // kiểm tra file ảnh
        ]);

        $data = $request->only(['name','email','phone','address','status']);
        $data['role'] = 'customer';
        $data['password'] = Hash::make($request->password);


        // Upload avatar nếu có
        if ($request->hasFile('avatar')) {
            $avatarName = time() . '_' . $request->file('avatar')->getClientOriginalName();
            $request->file('avatar')->move(public_path('images/avatars'), $avatarName);
            $data['avatar'] = $avatarName;
        }

        User::create($data);

        return redirect()->route('admin.users.index')->with('success', 'Thêm user thành công');
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
            // 'role' => 'required|in:customer,staff,admin',
            'status' => 'required|in:active,inactive,banned',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048', // thêm validation avatar
        ]);

        $data = [
            'name'    => $request->name,
            'email'   => $request->email,
            'password'=> $request->password
                            ? Hash::make($request->password)
                            : $user->password,
            'phone'   => $request->phone,
            'address' => $request->address,
            'status'  => $request->status,
            'role'    => 'customer',
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

        return redirect()->route('admin.users.index')->with('success', 'Cập nhật user thành công');
    }


    // Xóa user
    public function destroy(User $user)
    {
        if ($user->avatar && file_exists(public_path('images/avatars/'.$user->avatar))) {
        @unlink(public_path('images/avatars/'.$user->avatar));
        }
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Xóa user thành công');
    }

    public function show(User $user)
    {
        $user->load([
            'orders' => function ($q) {
                $q->latest()->limit(3);
            }
        ]);

        return response()->json([
            'id'      => $user->id,
            'name'    => $user->name,
            'email'   => $user->email,
            'phone'   => $user->phone,
            'address' => $user->address,
            'avatar'  => $user->avatar
                ? asset('images/avatars/'.$user->avatar)
                : asset('images/avatars/default.png'),

            'orders'  => $user->orders->map(function ($order) {
                return [
                    'order_number' => $order->order_number,
                    'date'         => $order->created_at->format('d/m/Y'),
                    'total'        => number_format($order->total_amount).' đ',
                    'status'       => $order->status,
                ];
            }),
        ]);
    }

}

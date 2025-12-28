<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // =========================
    // DANH SÁCH KHÁCH HÀNG
    // =========================
    public function index(Request $request)
    {
        $customerRoleId = Role::where('name','customer')->value('id');

        $query = User::withCount('orders')
            ->withSum('orders', 'total_amount')
            ->where('role_id', $customerRoleId);

        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', "%{$keyword}%")
                  ->orWhere('email', 'like', "%{$keyword}%")
                  ->orWhere('phone', 'like', "%{$keyword}%");
            });
        }

        match ($request->get('sort', 'date_desc')) {
            'name_asc'  => $query->orderBy('name'),
            'name_desc' => $query->orderByDesc('name'),
            'date_asc'  => $query->orderBy('created_at'),
            default     => $query->orderByDesc('created_at'),
        };

        $users = $query->paginate(10)->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    // =========================
    // TẠO USER MỚI
    // =========================
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'phone'    => 'nullable|string|max:20',
            'address'  => 'nullable|string|max:255',
            'status'   => 'required|in:active,inactive,banned',
            'avatar'   => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $customerRoleId = Role::where('name','customer')->value('id');

        $data = $request->only(['name','email','phone','address','status']);
        $data['role_id'] = $customerRoleId;
        $data['password'] = Hash::make($request->password);

        if ($request->hasFile('avatar')) {
            $avatarName = time().'_'.$request->avatar->getClientOriginalName();
            $request->avatar->move(public_path('images/avatars'), $avatarName);
            $data['avatar'] = $avatarName;
        }

        User::create($data);

        return redirect()->route('admin.users.index')->with('success','Thêm user thành công');
    }

    // =========================
    // CẬP NHẬT USER
    // =========================
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => ['required','email', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|min:6|confirmed',
            'phone'    => 'nullable|string|max:20',
            'address'  => 'nullable|string|max:255',
            'status'   => 'required|in:active,inactive,banned',
            'avatar'   => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $data = $request->only(['name','email','phone','address','status']);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        if ($request->hasFile('avatar')) {
            if ($user->avatar && file_exists(public_path('images/avatars/'.$user->avatar))) {
                @unlink(public_path('images/avatars/'.$user->avatar));
            }

            $avatarName = time().'_'.$request->avatar->getClientOriginalName();
            $request->avatar->move(public_path('images/avatars'), $avatarName);
            $data['avatar'] = $avatarName;
        }

        $user->update($data);

        return redirect()->route('admin.users.index')->with('success','Cập nhật user thành công');
    }

    // =========================
    // XÓA USER
    // =========================
    public function destroy(User $user)
    {
        if ($user->avatar && file_exists(public_path('images/avatars/'.$user->avatar))) {
            @unlink(public_path('images/avatars/'.$user->avatar));
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success','Xóa user thành công');
    }

    // =========================
    // CHI TIẾT USER (AJAX)
    // =========================
    public function show(User $user)
    {
        $user->load(['orders' => fn ($q) => $q->latest()->limit(3)]);

        return response()->json([
            'id'      => $user->id,
            'name'    => $user->name,
            'email'   => $user->email,
            'phone'   => $user->phone,
            'address' => $user->address,
            'avatar'  => $user->avatar
                ? asset('images/avatars/'.$user->avatar)
                : asset('images/avatars/default.png'),

            'orders' => $user->orders->map(fn ($order) => [
                'order_number' => $order->order_number,
                'date'   => $order->created_at->format('d/m/Y'),
                'total'  => number_format($order->total_amount).' đ',
                'status' => $order->status,
            ]),
        ]);
    }
}

<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    // =======================
    // DANH SÁCH NHÂN VIÊN
    // =======================
    public function index(Request $request)
    {
        // ================== ROLE (trừ customer) ==================
        $roles = Role::where('name', '!=', 'customer')->get();

        // ================== QUERY NHÂN VIÊN ==================
        $query = User::with('role')
            ->whereHas('role', function ($q) {
                $q->where('name', '!=', 'customer');
            });

        // ================== SEARCH ==================
        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', "%$keyword%")
                  ->orWhere('email', 'like', "%$keyword%")
                  ->orWhere('phone', 'like', "%$keyword%");
            });
        }

        // ================== FILTER ROLE ==================
        if ($request->role && $request->role !== 'all') {
            $query->whereHas('role', function ($q) use ($request) {
                $q->where('name', $request->role);
            });
        }

        // ================== SORT ==================
        switch ($request->sort) {
            case 'date_asc':
                $query->orderBy('created_at', 'asc');
                break;
            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
        }

        // ================== PAGINATION ==================
        $employees = $query->paginate(10)->withQueryString();

        // ================== DASHBOARD COUNT ==================
        $totalEmployees = User::whereHas('role', fn($q) =>
            $q->where('name', '!=', 'customer')
        )->count();

        $activeEmployees = User::whereHas('role', fn($q) =>
            $q->where('name', '!=', 'customer')
        )->where('status', 'active')->count();

        $bannedEmployees = User::whereHas('role', fn($q) =>
            $q->where('name', '!=', 'customer')
        )->where('status', 'banned')->count();

        return view('admin.employees.index', compact(
            'employees',
            'roles',
            'totalEmployees',
            'activeEmployees',
            'bannedEmployees'
        ));
    }

    // =======================
    // THÊM NHÂN VIÊN
    // =======================
    public function store(Request $request)
    {
        // ================== VALIDATION ==================
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'phone'    => 'nullable|string|max:20',
            'address'  => 'nullable|string|max:255',
            'status'   => 'required|in:active,inactive,banned',
            'role'     => [
                'required',
                Rule::exists('roles', 'name')->where(fn ($q) =>
                    $q->where('name', '!=', 'customer') // ❌ không cho tạo customer
                )
            ],
            'avatar'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // ================== UPLOAD AVATAR ==================
        $avatarName = null;
        if ($request->hasFile('avatar')) {
            $avatarName = Str::uuid() . '.' . $request->avatar->extension();
            $request->avatar->move(public_path('images/avatars'), $avatarName);
        }

        // ================== LẤY ROLE ==================
        $role = Role::where('name', $request->role)->firstOrFail();

        // ================== CREATE USER ==================
        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'phone'    => $request->phone,
            'address'  => $request->address,
            'avatar'   => $avatarName,
            'status'   => $request->status,
            'role_id'  => $role->id,
        ]);

        return redirect()
            ->route('admin.employees.index')
            ->with('success', 'Thêm nhân viên thành công');
    }

    // =======================
    // CẬP NHẬT NHÂN VIÊN
    // =======================
    public function update(Request $request, User $employee)
    {
        $request->validate([
            'name'   => 'required|string|max:255',
            'email'  => [
                'required',
                'email',
                Rule::unique('users')->ignore($employee->id),
            ],
            'phone'  => 'nullable|string|max:20',
            'address'=> 'nullable|string|max:255',
            'status' => 'required|in:active,inactive,banned',
            'role'   => [
                'required',
                Rule::exists('roles', 'name')->where(fn ($q) =>
                    $q->where('name', '!=', 'customer')
                )
            ],
            'password' => 'nullable|min:6|confirmed',
            'avatar'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // UPDATE AVATAR
        if ($request->hasFile('avatar')) {
            if ($employee->avatar && file_exists(public_path('images/avatars/'.$employee->avatar))) {
                unlink(public_path('images/avatars/'.$employee->avatar));
            }

            $avatarName = Str::uuid().'.'.$request->avatar->extension();
            $request->avatar->move(public_path('images/avatars'), $avatarName);
            $employee->avatar = $avatarName;
        }

        // UPDATE ROLE
        $role = Role::where('name', $request->role)->firstOrFail();
        $employee->role_id = $role->id;

        // UPDATE BASIC INFO
        $employee->update([
            'name'    => $request->name,
            'email'   => $request->email,
            'phone'   => $request->phone,
            'address' => $request->address,
            'status'  => $request->status,
        ]);

        // UPDATE PASSWORD (nếu có)
        if ($request->filled('password')) {
            $employee->password = Hash::make($request->password);
            $employee->save();
        }

        return back()->with('success', 'Cập nhật nhân viên thành công');
    }

    // =======================
    // XÓA NHÂN VIÊN
    // =======================
    public function destroy(User $employee)
    {
        if (
            auth()->id() === $employee->id &&
            $employee->role->name === 'admin'
        ) {
            return back()->with('error','Không thể xóa admin đang đăng nhập');
        }

        if ($employee->avatar && file_exists(public_path('images/avatars/'.$employee->avatar))) {
            @unlink(public_path('images/avatars/'.$employee->avatar));
        }

        $employee->delete();

        return redirect()->route('admin.employees.index')
            ->with('success','Xóa nhân viên thành công');
    }
}

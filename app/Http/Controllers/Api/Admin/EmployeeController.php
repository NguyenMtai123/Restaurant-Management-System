<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\Role;
use App\Models\User;
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
        $adminId = Role::where('name','admin')->value('id');
        $staffId = Role::where('name','staff')->value('id');

        $query = User::with('role')
            ->whereIn('role_id', [$adminId, $staffId]);

        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', "%{$keyword}%")
                  ->orWhere('email', 'like', "%{$keyword}%")
                  ->orWhere('phone', 'like', "%{$keyword}%");
            });
        }

        if ($request->filled('role') && $request->role !== 'all') {
            $roleId = Role::where('name', $request->role)->value('id');
            $query->where('role_id', $roleId);
        }

        match ($request->get('sort','date_desc')) {
            'name_asc'  => $query->orderBy('name'),
            'name_desc' => $query->orderBy('name','desc'),
            'date_asc'  => $query->orderBy('created_at'),
            default     => $query->orderBy('created_at','desc'),
        };

        $employees = $query->paginate(5)->withQueryString();

        $totalEmployees  = $employees->total();
        $activeEmployees = User::whereIn('role_id', [$adminId,$staffId])
                                ->where('status','active')->count();
        $inactiveEmployees = User::whereIn('role_id', [$adminId,$staffId])
                                ->where('status','inactive')->count();
        $bannedEmployees = User::whereIn('role_id', [$adminId,$staffId])
                                ->where('status','banned')->count();

        return view('admin.employees.index', compact(
            'employees',
            'totalEmployees',
            'activeEmployees',
            'inactiveEmployees',
            'bannedEmployees'
        ));
    }

    // =======================
    // THÊM NHÂN VIÊN
    // =======================
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'phone'    => 'nullable|max:20',
            'address'  => 'nullable|max:255',
            'role'     => 'required|in:admin,staff',
            'status'   => 'required|in:active,inactive,banned',
            'avatar'   => 'nullable|image|max:2048',
        ]);

        $roleId = Role::where('name', $request->role)->value('id');

        $data = $request->only(['name','email','phone','address','status']);
        $data['password'] = Hash::make($request->password);
        $data['role_id']  = $roleId;

        if ($request->hasFile('avatar')) {
            $avatarName = time().'_'.$request->avatar->getClientOriginalName();
            $request->avatar->move(public_path('images/avatars'), $avatarName);
            $data['avatar'] = $avatarName;
        }

        User::create($data);

        return redirect()->route('admin.employees.index')
            ->with('success','Thêm nhân viên thành công');
    }

    // =======================
    // CẬP NHẬT NHÂN VIÊN
    // =======================
    public function update(Request $request, User $employee)
    {
        if (
            Auth::id() === $employee->id &&
            $employee->role->name === 'admin' &&
            $request->status !== 'active'
        ) {
            return back()->with('error','Không thể khóa admin đang đăng nhập');
        }

        $request->validate([
            'name'     => 'required|max:255',
            'email'    => ['required','email', Rule::unique('users')->ignore($employee->id)],
            'password' => 'nullable|min:6|confirmed',
            'phone'    => 'nullable|max:20',
            'address'  => 'nullable|max:255',
            'role'     => 'required|in:admin,staff',
            'status'   => 'required|in:active,inactive,banned',
            'avatar'   => 'nullable|image|max:2048',
        ]);

        $roleId = Role::where('name',$request->role)->value('id');

        $data = $request->only(['name','email','phone','address','status']);
        $data['role_id'] = $roleId;

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        if ($request->hasFile('avatar')) {
            if ($employee->avatar && file_exists(public_path('images/avatars/'.$employee->avatar))) {
                @unlink(public_path('images/avatars/'.$employee->avatar));
            }

            $avatarName = time().'_'.$request->avatar->getClientOriginalName();
            $request->avatar->move(public_path('images/avatars'), $avatarName);
            $data['avatar'] = $avatarName;
        }

        $employee->update($data);

        return redirect()->route('admin.employees.index')
            ->with('success','Cập nhật nhân viên thành công');
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

<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    // Danh sách nhân viên
    public function index(Request $request)
    {
        $query = User::whereIn('role', ['admin','staff']);

        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', "%$keyword%")
                ->orWhere('email', 'like', "%$keyword%")
                ->orWhere('phone', 'like', "%$keyword%");
            });
        }

        if ($request->filled('role') && $request->role !== 'all') {
            $query->where('role', $request->role);
        }

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
                $query->orderBy('created_at', 'desc'); // mới nhất
        }

        $employees = $query->paginate(5)->withQueryString();

        $totalEmployees    = $employees->total();
        $activeEmployees   = User::whereIn('role',['admin','staff'])->where('status','active')->count();
        $inactiveEmployees = User::whereIn('role',['admin','staff'])->where('status','inactive')->count();
        $bannedEmployees   = User::whereIn('role',['admin','staff'])->where('status','banned')->count();

        return view('admin.employees.index', compact(
            'employees',
            'totalEmployees',
            'activeEmployees',
            'inactiveEmployees',
            'bannedEmployees'
        ));
    }


    // Lưu nhân viên mới
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'phone'    => 'nullable|string|max:20',
            'address'  => 'nullable|string|max:255',
            'role'     => 'required|in:admin,staff',
            'status'   => 'required|in:active,inactive,banned',
            'avatar'   => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $data = $request->only(['name','email','phone','address','role','status']);
        $data['password'] = Hash::make($request->password);

        // Upload avatar nếu có
        if ($request->hasFile('avatar')) {
            $avatarName = time().'_'.$request->file('avatar')->getClientOriginalName();
            $request->file('avatar')->move(public_path('images/avatars'), $avatarName);
            $data['avatar'] = $avatarName;
        }

        User::create($data);

        return redirect()->route('admin.employees.index')
                         ->with('success','Thêm nhân viên thành công');
    }

    // Cập nhật nhân viên
    public function update(Request $request, User $employee)
    {
        if ( Auth::id() === $employee->id && $employee->role === 'admin' && $request->status !== 'active' ) {
            return redirect()->route('admin.employees.index')
                ->with('error', 'Không thể khóa hoặc ngưng hoạt động tài khoản admin hiện tại');
        }
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => ['required','email', Rule::unique('users')->ignore($employee->id)],
            'password' => 'nullable|string|min:6|confirmed',
            'phone'    => 'nullable|string|max:20',
            'address'  => 'nullable|string|max:255',
            'role'     => 'required|in:admin,staff',
            'status'   => 'required|in:active,inactive,banned',
            'avatar'   => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $data = [
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => $request->password ? Hash::make($request->password) : $employee->password,
            'phone'    => $request->phone,
            'address'  => $request->address,
            'role'     => $request->role,
            'status'   => $request->status,
        ];

        // Upload avatar nếu có
        if ($request->hasFile('avatar')) {
            $avatarName = time().'_'.$request->file('avatar')->getClientOriginalName();
            $request->file('avatar')->move(public_path('images/avatars'), $avatarName);
            $data['avatar'] = $avatarName;

            if($employee->avatar && file_exists(public_path('images/avatars/'.$employee->avatar))){
                @unlink(public_path('images/avatars/'.$employee->avatar));
            }
        }

        $employee->update($data);

        return redirect()->route('admin.employees.index')
                         ->with('success','Cập nhật nhân viên thành công');
    }

    // Xóa nhân viên
    public function destroy(User $employee)
    {
        // Không xóa admin đang đăng nhập
        if(auth()->user()->id === $employee->id && $employee->role === 'admin') {
            return redirect()->route('admin.employees.index')
                            ->with('error','Không thể xóa admin hiện tại đang đăng nhập');
        }

        // Xóa avatar nếu tồn tại
        if ($employee->avatar && file_exists(public_path('images/avatars/'.$employee->avatar))) {
            @unlink(public_path('images/avatars/'.$employee->avatar));
        }

        $employee->delete();

        return redirect()->route('admin.employees.index')
                        ->with('success','Xóa nhân viên thành công');
    }


}

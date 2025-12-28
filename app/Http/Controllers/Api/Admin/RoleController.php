<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::with('permissions')->paginate(5);
        $permissions = Permission::all();

        return view('admin.roles.index', compact('roles', 'permissions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
            'label' => 'required',
        ]);

        Role::create($request->only('name','label'));
        return redirect()->back()->with('success', 'Thêm vai trò thành công!');
    }

    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|unique:roles,name,' . $role->id,
            'label' => 'required',
        ]);

        $role->update($request->only('name','label'));
        return redirect()->back()->with('success', 'Cập nhật vai trò thành công!');
    }

    public function destroy(Role $role)
    {
        $role->delete();
        return redirect()->back()->with('success', 'Xóa vai trò thành công!');
    }

    public function updatePermissions(Request $request, Role $role)
    {
        $role->permissions()->sync($request->permissions ?? []);

        return redirect()->back()
            ->with('success', 'Cập nhật quyền cho vai trò thành công!');
    }

}

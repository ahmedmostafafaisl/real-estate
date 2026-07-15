<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::with('permissions')->withCount('users')->get();
        $permissions = Permission::all();

        return view('admin.roles', compact('roles', 'permissions'));
    }

    public function store(Request $request)
    {
        $data = $request->validate(['name' => ['required', 'string', 'unique:roles,name']]);
        Role::create(['name' => $data['name'], 'guard_name' => 'web']);

        return back()->with('status', __('admin.flash_role_created'));
    }

    public function syncPermissions(Role $role, Request $request)
    {
        $data = $request->validate(['permissions' => ['nullable', 'array']]);
        $role->syncPermissions($data['permissions'] ?? []);

        return back()->with('status', __('admin.flash_permissions_updated', ['role' => $role->name]));
    }
}

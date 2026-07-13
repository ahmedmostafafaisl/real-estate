<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        return Role::with('permissions')->withCount('users')->get();
    }

    public function store(Request $request)
    {
        $data = $request->validate(['name' => ['required', 'string', 'unique:roles,name']]);
        return Role::create(['name' => $data['name'], 'guard_name' => 'web']);
    }

    // PUT /api/admin/roles/{role}/permissions — replace the full permission set
    public function syncPermissions(Role $role, Request $request)
    {
        $data = $request->validate(['permissions' => ['required', 'array'], 'permissions.*' => ['string']]);
        $role->syncPermissions($data['permissions']);

        return $role->load('permissions');
    }

    public function permissions()
    {
        return Permission::all();
    }
}

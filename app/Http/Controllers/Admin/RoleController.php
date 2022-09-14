<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::all();

        return  view('admin.role.index', compact('roles'));
    }

    public function create()
    {
        $permissions = Permission::all();

        return  view('admin.role.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $role = Role::create($request->only('name', 'description'));

        if ($request->has('permissions')) {
            foreach ($request->get('permissions') as $p) {
                $role->rolePermissions()->create(['permission_id' => $p]);
            }
        }

        return redirect()->route('admin.role.index');
    }

    public function edit(Role $role)
    {
        $permissions = Permission::all();

        return view('admin.category.edit', compact('permissions', 'role'));
    }

    public function update(Request $request, Role $role)
    {
        $role->update($request->only('name', 'description'));

        $role->rolePermissions()->delete();
        if ($request->has('permissions')) {
            foreach ($request->get('permissions') as $p) {
                $role->rolePermissions()->create(['permission_id' => $p]);
            }
        }

        return redirect()->route('admin.role.index');
    }

    public function delete(Role $role)
    {
        $role->delete();

        return redirect()->route('admin.role.index');
    }
}

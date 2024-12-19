<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::get();
        return view('role-permission.role.index', [
            'roles' => $roles
        ]);
    }
    public function create()
    {
        return view('role-permission.role.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
            ]
        ]);

        // Check if the role already exists
        $existingRole = Role::where('name', $request->name)->first();
        if ($existingRole) {
            return redirect('roles')->with('status', 'Role already exists.');
        }
        // Create the new role
        Role::create([
            'name' => $request->name
        ]);
        return redirect('roles')->with('status', 'Role created successfully');
    }
    public function show(string $id)
    {
        //
    }
    public function edit(Role $role)
    {
        return view('role-permission.role.edit', [
            'role' => $role
        ]);
    }
    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'unique:roles,name,'.$role->id       
            ]
        ]);
        $role->update([
            'name' => $request->name
        ]);
        return redirect('roles')->with('status', 'Role Updated Successfully');
    }
    public function destroy($roleId)
    {
        $role = Role::find($roleId);
        $role->delete();
        return redirect('roles')->with('status', 'Role Deleted Successfully');
    }
    public function addPermissionRole($roleId)
    {
        $permissions = Permission::get();
        $role = Role::findOrFail($roleId);
        $rolePermissions = DB::table('role_has_permissions')
                                    ->where('role_has_permissions.role_id', $role->id)
                                    ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
                                    ->all();
        return view('role-permission.role.add-permissions', [
            'role' => $role,
            'permissions' => $permissions,
            'rolePermissions' => $rolePermissions
        ]);
    }
    public function givePermissionRole(Request $request, $roleId)
    {
        $request->validate([
            'permission' => 'required'
        ]);
        $role = Role::findOrFail($roleId);
        $role->syncPermissions($request->permission);
        return redirect()->back()->with('status', 'Permission added to role');
    }
}

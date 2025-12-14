<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Role;
use App\Models\Permission;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:roles.view')->only(['index', 'table', 'show']);
        $this->middleware('permission:roles.create')->only(['create', 'store']);
        $this->middleware('permission:roles.edit')->only(['edit', 'update', 'attachPermission', 'detachPermission']);
        $this->middleware('permission:roles.delete')->only(['delete']);
    }

    public function index()
    {
        return view('roles.index');
    }

    public function table()
    {
        $roles = Role::select('id', 'name');

        return DataTables::of($roles)
            ->toJson();
    }

    public function create()
    {
        return view('roles.create');
    }

    public function store(StoreRoleRequest $request)
    {
        $role = Role::create([
            'name' => $request->get('name')
        ]);

        return redirect()->route('roles.show', $role->id)
            ->with('success', 'Role created successfully');
    }

    public function show(Role $role)
    {
        $role->load('permissions');
        $availablePermissions = Permission::whereNotIn('id', $role->permissions->pluck('id'))->get();
        
        return view('roles.show', compact('role', 'availablePermissions'));
    }

    public function edit(Role $role)
    {
        return view('roles.edit', compact('role'));
    }

    public function update(UpdateRoleRequest $request, Role $role)
    {
        $role->update([
            'name' => $request->get('name')
        ]);

        return redirect()->route('roles.index')
            ->with('success', 'Role updated successfully');
    }

    public function delete(Role $role)
    {
        $role->delete();

        return ok();
    }

    public function attachPermission(Role $role)
    {
        $role->givePermissionTo(request('permission_id'));

        return redirect()->route('roles.show', $role->id)
            ->with('success', 'Permission attached successfully');
    }

    public function detachPermission(Role $role, Permission $permission)
    {
        $role->revokePermissionTo($permission);

        return ok();
    }
}
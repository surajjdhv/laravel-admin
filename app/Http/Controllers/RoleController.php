<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index(): View
    {
        $roles = Role::query()
            ->withCount(['permissions', 'users'])
            ->orderBy('name')
            ->get();

        return view('roles.index', compact('roles'));
    }

    public function create(): View
    {
        $permissions = Permission::query()->orderBy('name')->get();

        return view('roles.create', compact('permissions'));
    }

    public function store(StoreRoleRequest $request): RedirectResponse
    {
        $role = Role::create([
            'name' => $request->get('name'),
            'guard_name' => 'web',
        ]);

        $permissionIds = $request->input('permissions', []);
        $permissionNames = Permission::query()
            ->whereIn('id', $permissionIds)
            ->pluck('name')
            ->all();

        $role->syncPermissions($permissionNames);

        return redirect()->route('roles.index')->with('success', 'Role created successfully!');
    }

    public function edit(Role $role): View
    {
        $permissions = Permission::query()->orderBy('name')->get();
        $role->load('permissions');

        return view('roles.edit', compact('role', 'permissions'));
    }

    public function update(UpdateRoleRequest $request, Role $role): RedirectResponse
    {
        $role->update([
            'name' => $request->get('name'),
        ]);

        $permissionIds = $request->input('permissions', []);
        $permissionNames = Permission::query()
            ->whereIn('id', $permissionIds)
            ->pluck('name')
            ->all();

        $role->syncPermissions($permissionNames);

        return redirect()->route('roles.index')->with('success', 'Role updated successfully!');
    }

    public function delete(Role $role): RedirectResponse
    {
        if ($role->name === 'Admin') {
            return redirect()->route('roles.index')->with('danger', 'Admin role cannot be deleted.');
        }

        $role->delete();

        return redirect()->route('roles.index')->with('success', 'Role deleted successfully!');
    }
}

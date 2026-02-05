<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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

        activity()
            ->causedBy($request->user())
            ->performedOn($role)
            ->event('role_created')
            ->withProperties([
                'role_id' => $role->id,
                'name' => $role->name,
                'permissions' => $permissionNames,
            ])
            ->log('Role created');

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
        $previousPermissions = $role->permissions()->pluck('name')->all();

        $role->update([
            'name' => $request->get('name'),
        ]);

        $permissionIds = $request->input('permissions', []);
        $permissionNames = Permission::query()
            ->whereIn('id', $permissionIds)
            ->pluck('name')
            ->all();

        $role->syncPermissions($permissionNames);

        activity()
            ->causedBy($request->user())
            ->performedOn($role)
            ->event('role_updated')
            ->withProperties([
                'role_id' => $role->id,
                'name' => $role->name,
                'previous_permissions' => $previousPermissions,
                'permissions' => $permissionNames,
            ])
            ->log('Role updated');

        return redirect()->route('roles.index')->with('success', 'Role updated successfully!');
    }

    public function delete(Request $request, Role $role): RedirectResponse
    {
        if ($role->name === 'Admin') {
            return redirect()->route('roles.index')->with('danger', 'Admin role cannot be deleted.');
        }

        $role->delete();

        activity()
            ->causedBy($request->user())
            ->performedOn($role)
            ->event('role_deleted')
            ->withProperties([
                'role_id' => $role->id,
                'name' => $role->name,
            ])
            ->log('Role deleted');

        return redirect()->route('roles.index')->with('success', 'Role deleted successfully!');
    }
}

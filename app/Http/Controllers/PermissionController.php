<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePermissionRequest;
use App\Http\Requests\UpdatePermissionRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function index(): View
    {
        $permissions = Permission::query()
            ->withCount('roles')
            ->orderBy('name')
            ->get();

        return view('permissions.index', compact('permissions'));
    }

    public function create(): View
    {
        return view('permissions.create');
    }

    public function store(StorePermissionRequest $request): RedirectResponse
    {
        $permission = Permission::create([
            'name' => $request->get('name'),
            'guard_name' => 'web',
        ]);

        activity()
            ->causedBy($request->user())
            ->performedOn($permission)
            ->event('permission_created')
            ->withProperties([
                'permission_id' => $permission->id,
                'name' => $permission->name,
            ])
            ->log('Permission created');

        return redirect()->route('permissions.index')->with('success', 'Permission created successfully!');
    }

    public function edit(Permission $permission): View
    {
        return view('permissions.edit', compact('permission'));
    }

    public function update(UpdatePermissionRequest $request, Permission $permission): RedirectResponse
    {
        $permission->update([
            'name' => $request->get('name'),
        ]);

        activity()
            ->causedBy($request->user())
            ->performedOn($permission)
            ->event('permission_updated')
            ->withProperties([
                'permission_id' => $permission->id,
                'name' => $permission->name,
            ])
            ->log('Permission updated');

        return redirect()->route('permissions.index')->with('success', 'Permission updated successfully!');
    }

    public function delete(Request $request, Permission $permission): RedirectResponse
    {
        $permission->delete();

        activity()
            ->causedBy($request->user())
            ->performedOn($permission)
            ->event('permission_deleted')
            ->withProperties([
                'permission_id' => $permission->id,
                'name' => $permission->name,
            ])
            ->log('Permission deleted');

        return redirect()->route('permissions.index')->with('success', 'Permission deleted successfully!');
    }
}

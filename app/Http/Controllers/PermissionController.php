<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePermissionRequest;
use App\Http\Requests\UpdatePermissionRequest;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Permission;

class PermissionController extends Controller
{
    public function index()
    {
        return view('permissions.index');
    }

    public function table()
    {
        $permissions = Permission::select('id', 'name');

        return DataTables::of($permissions)
            ->toJson();
    }

    public function create()
    {
        return view('permissions.create');
    }

    public function store(StorePermissionRequest $request)
    {
        $permission = Permission::create([
            'name' => $request->get('name')
        ]);

        return redirect()->route('permissions.show', $permission->id)
            ->with('success', 'Permission created successfully');
    }

    public function show(Permission $permission)
    {
        return view('permissions.show', compact('permission'));
    }

    public function edit(Permission $permission)
    {
        return view('permissions.edit', compact('permission'));
    }

    public function update(UpdatePermissionRequest $request, Permission $permission)
    {
        $permission->update([
            'name' => $request->get('name')
        ]);

        return redirect()->route('permissions.index')
            ->with('success', 'Permission updated successfully');
    }

    public function delete(Permission $permission)
    {
        $permission->delete();

        return ok();
    }
}


<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function index()
    {
        return view('users.index');
    }

    public function table()
    {
        $users = User::select('id', 'name', 'email', 'type', 'created_by')
                    ->with('createdBy', 'updatedBy');

        return DataTables::of($users)
            ->editColumn('type', function ($user) {
                return ucwords($user->type);
            })
            ->editColumn('created_by', function ($user) {
                return $user->createdBy ? $user->createdBy->name : '';
            })
            ->toJson();
    }

    public function create()
    {
        $userTypes = User::getEnums('type');

        return view('users.create', compact('userTypes'));
    }

    public function store(StoreUserRequest $request)
    {
        if ($request->has('send-password')) {
            $password = Str::random(6);
            $request->merge(['password' => $password]);
        }

        $user = User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => $request->get('password'),
            'type' => $request->get('type'),
            'is_active' => $request->get('is_active'),
            'created_by' => request()->user()->id,
            'updated_by' => request()->user()->id
        ]);

        if ($request->has('send-password')) {
            // Send email to the user with password
        }

        return redirect()->route('users.show', $user->id)
            ->with('success', 'User added successfully!');
    }

    public function show(User $user)
    {
        $user = $user->load('createdBy', 'updatedBy');
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $user = $user->load('createdBy', 'updatedBy');
        $userTypes = User::getEnums('type');

        return view('users.edit', compact('user', 'userTypes'));
    }

    public function update(User $user, UpdateUserRequest $request)
    {
        $user->update([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'type' => $request->get('type'),
            'is_active' => $request->get('is_active'),
        ]);

        return redirect()->route('users.index')->with('success', 'User updated successfully!');
    }

    public function delete(User $user)
    {
        $user->delete();

        return ok();
    }
}
<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Mail\SendPasswordMail;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Mail;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function index(): \Illuminate\Contracts\View\View
    {
        return view('users.index');
    }

    public function table(): JsonResponse
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

    public function create(): \Illuminate\Contracts\View\View
    {
        $userTypes = User::getEnums('type');

        return view('users.create', compact('userTypes'));
    }

    public function store(StoreUserRequest $request): RedirectResponse
    {
        if ($request->has('send-password')) {
            $password = Str::password(8, true, true, false);

            $request->merge([
                'password' => $password,
                'password_reset_required' => true,
            ]);
        }

        $user = User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => $request->get('password'),
            'type' => $request->get('type'),
            'is_active' => $request->get('is_active'),
            'created_by' => request()->user()->id,
            'updated_by' => request()->user()->id,
        ]);

        if ($request->has('send-password')) {
            // Send email to the user with password
            Mail::to($request->get('email'))->send(new SendPasswordMail(...$request->only(['name', 'password'])));
        }

        activity()
            ->causedBy($request->user())
            ->performedOn($user)
            ->event('user_created')
            ->withProperties([
                'user_id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'type' => $user->type,
                'is_active' => $user->is_active,
            ])
            ->log('User created');

        return redirect()->route('users.show', $user->id)
            ->with('success', 'User added successfully!');
    }

    public function show(User $user): \Illuminate\Contracts\View\View
    {
        $user = $user->load('createdBy', 'updatedBy');

        return view('users.show', compact('user'));
    }

    public function edit(User $user): \Illuminate\Contracts\View\View
    {
        $user = $user->load('createdBy', 'updatedBy');
        $userTypes = User::getEnums('type');

        return view('users.edit', compact('user', 'userTypes'));
    }

    public function update(User $user, UpdateUserRequest $request): RedirectResponse
    {
        $user->update([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'type' => $request->get('type'),
            'is_active' => $request->get('is_active'),
        ]);

        $changes = array_keys($user->getChanges());

        activity()
            ->causedBy($request->user())
            ->performedOn($user)
            ->event('user_updated')
            ->withProperties([
                'user_id' => $user->id,
                'changes' => $changes,
            ])
            ->log('User updated');

        return redirect()->route('users.index')->with('success', 'User updated successfully!');
    }

    public function delete(User $user): JsonResponse
    {
        $user->delete();

        activity()
            ->causedBy(request()->user())
            ->performedOn($user)
            ->event('user_deleted')
            ->withProperties([
                'user_id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ])
            ->log('User deleted');

        return ok();
    }
}

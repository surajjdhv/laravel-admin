<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;

class ChangePasswordController extends Controller
{
    protected $redirectTo = '/';

    public function showChangeForm(): \Illuminate\Contracts\View\Factory|\Illuminate\View\View
    {
        return view('auth.passwords.change');
    }

    public function change(Request $request): RedirectResponse|\Illuminate\Http\JsonResponse
    {
        $request->validate(['password' => ['required', 'confirmed', Password::defaults()]]);

        $user = $request->user();

        $user->update([
            'password' => $request->get('password'),
            'password_change_required' => false,
        ]);

        activity()
            ->causedBy($user)
            ->performedOn($user)
            ->event('user_password_changed')
            ->log('Password changed');

        return redirect($this->redirectTo);
    }
}

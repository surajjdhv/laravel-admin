<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index(): \Illuminate\Contracts\View\View
    {
        return view('profile');
    }

    public function storePassword(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'confirmed', 'min:6'],
        ]);

        $user = $request->user();

        $user->update([
            'password' => $request->password,
        ]);

        activity()
            ->causedBy($user)
            ->performedOn($user)
            ->event('user_password_changed')
            ->log('Password changed');

        return redirect()->route('home')->with('success', 'Password changed successfully!');
    }
}

<?php

namespace App\Http\Controllers;

use Hash;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        return view('profile');
    }

    public function storePassword(Request $request)
    {
        $request->validate([
            'password' => ['required', 'confirmed', 'min:6']
        ]);

        auth()->user()->update([
            'password' => $request->password
        ]);

        return redirect()->route('home')->with('success', 'Password changed successfully!');
    }
}

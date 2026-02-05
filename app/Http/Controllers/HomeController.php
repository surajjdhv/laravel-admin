<?php

namespace App\Http\Controllers;

use App\Models\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        /** @var User */
        $loggedInUser = auth()->user();

        return view('home')
            ->with([
                'users_count' => $loggedInUser->can('users.view') ? User::count() : 1,
            ]);
    }
}

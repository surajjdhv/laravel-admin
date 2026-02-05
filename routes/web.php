<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\ChangePasswordController;
use Tabuna\Breadcrumbs\Trail;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::middleware('auth')->group(function () {
    Route::get('password/change', [ChangePasswordController::class, 'showChangeForm'])->name('password.change');
    Route::post('password/change', [ChangePasswordController::class, 'change'])->name('password.store');

    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])
        ->name('home')
        ->breadcrumbs(fn (Trail $trail) =>
            $trail->push('Home', route('home'))
        );

    Route::group([
        'prefix' => 'profile',
        'as' => 'profile.'
    ], function () {
        Route::get('/', [ProfileController::class, 'index'])
            ->name('index')
            ->breadcrumbs(fn (Trail $trail) =>
                $trail->parent('home')->push('Profile', route('profile.index'))
            );
        Route::post('storePassword', [ProfileController::class, 'storePassword'])->name('password');
    });

    Route::group([
        'prefix' => 'users',
        'as' => 'users.',
        'controller' => UserController::class
    ], function () {
        Route::get('/', 'index')
            ->name('index')
            ->breadcrumbs(fn (Trail $trail) =>
                $trail->parent('home')->push('Users', route('users.index'))
            );
        Route::get('table', 'table')->name('table');
        Route::get('create', 'create')
            ->name('create')
            ->breadcrumbs(fn (Trail $trail) =>
                $trail->parent('users.index')->push('Create user', route('users.create'))
            );
        Route::post('store', 'store')->name('store');

        Route::group([
            'prefix' => '{user}'
        ], function () {
            Route::get('/', 'show')
                ->name('show')
                ->breadcrumbs(fn (Trail $trail, \App\Models\User $user) =>
                    $trail->parent('users.index')->push($user->name, route('users.show', $user))
                );

            Route::get('edit', 'edit')
                ->name('edit')
                ->breadcrumbs(fn (Trail $trail, \App\Models\User $user) =>
                    $trail->parent('users.show', $user)->push('Edit', route('users.edit', $user))
                );

            Route::post('update', 'update')->name('update');
            Route::post('delete', 'delete')->name('delete');
        });
    });
});

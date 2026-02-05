<?php

use App\Http\Controllers\Auth\ChangePasswordController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Spatie\Activitylog\Models\Activity;
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
        ->breadcrumbs(fn (Trail $trail) => $trail->push('Home', route('home'))
        );

    Route::group([
        'prefix' => 'profile',
        'as' => 'profile.',
    ], function () {
        Route::get('/', [ProfileController::class, 'index'])
            ->name('index')
            ->breadcrumbs(fn (Trail $trail) => $trail->parent('home')->push('Profile', route('profile.index'))
            );
        Route::post('storePassword', [ProfileController::class, 'storePassword'])->name('password');
    });

    Route::group([
        'prefix' => 'users',
        'as' => 'users.',
        'controller' => UserController::class,
    ], function () {
        Route::get('/', 'index')
            ->name('index')
            ->middleware('permission:users.view')
            ->breadcrumbs(fn (Trail $trail) => $trail->parent('home')->push('Users', route('users.index'))
            );
        Route::get('table', 'table')
            ->name('table')
            ->middleware('permission:users.view');
        Route::get('create', 'create')
            ->name('create')
            ->middleware('permission:users.create')
            ->breadcrumbs(fn (Trail $trail) => $trail->parent('users.index')->push('Create user', route('users.create'))
            );
        Route::post('store', 'store')
            ->name('store')
            ->middleware('permission:users.create');

        Route::group([
            'prefix' => '{user}',
        ], function () {
            Route::get('/', 'show')
                ->name('show')
                ->middleware('permission:users.view')
                ->breadcrumbs(fn (Trail $trail, \App\Models\User $user) => $trail->parent('users.index')->push($user->name, route('users.show', $user))
                );

            Route::get('edit', 'edit')
                ->name('edit')
                ->middleware('permission:users.update')
                ->breadcrumbs(fn (Trail $trail, \App\Models\User $user) => $trail->parent('users.show', $user)->push('Edit', route('users.edit', $user))
                );

            Route::post('update', 'update')
                ->name('update')
                ->middleware('permission:users.update');
            Route::post('delete', 'delete')
                ->name('delete')
                ->middleware('permission:users.delete');
        });
    });

    Route::get('activity-logs', function (Request $request) {
        $activities = Activity::query()
            ->with(['causer', 'subject'])
            ->latest()
            ->paginate(25);

        return view('activity-logs.index', compact('activities'));
    })
        ->name('activity-logs.index')
        ->middleware('permission:activity-logs.view')
        ->breadcrumbs(fn (Trail $trail) => $trail->parent('home')->push('Activity Logs', route('activity-logs.index'))
        );

    Route::group([
        'prefix' => 'roles',
        'as' => 'roles.',
        'controller' => RoleController::class,
    ], function () {
        Route::get('/', 'index')
            ->name('index')
            ->middleware('permission:roles.view')
            ->breadcrumbs(fn (Trail $trail) => $trail->parent('home')->push('Roles', route('roles.index'))
            );
        Route::get('create', 'create')
            ->name('create')
            ->middleware('permission:roles.create')
            ->breadcrumbs(fn (Trail $trail) => $trail->parent('roles.index')->push('Create Role', route('roles.create'))
            );
        Route::post('store', 'store')
            ->name('store')
            ->middleware('permission:roles.create');

        Route::group([
            'prefix' => '{role}',
        ], function () {
            Route::get('edit', 'edit')
                ->name('edit')
                ->middleware('permission:roles.update')
                ->breadcrumbs(fn (Trail $trail, \Spatie\Permission\Models\Role $role) => $trail->parent('roles.index')->push($role->name, route('roles.edit', $role))
                );
            Route::post('update', 'update')
                ->name('update')
                ->middleware('permission:roles.update');
            Route::post('delete', 'delete')
                ->name('delete')
                ->middleware('permission:roles.delete');
        });
    });

    Route::group([
        'prefix' => 'permissions',
        'as' => 'permissions.',
        'controller' => PermissionController::class,
    ], function () {
        Route::get('/', 'index')
            ->name('index')
            ->middleware('permission:permissions.view')
            ->breadcrumbs(fn (Trail $trail) => $trail->parent('home')->push('Permissions', route('permissions.index'))
            );
        Route::get('create', 'create')
            ->name('create')
            ->middleware('permission:permissions.create')
            ->breadcrumbs(fn (Trail $trail) => $trail->parent('permissions.index')->push('Create Permission', route('permissions.create'))
            );
        Route::post('store', 'store')
            ->name('store')
            ->middleware('permission:permissions.create');

        Route::group([
            'prefix' => '{permission}',
        ], function () {
            Route::get('edit', 'edit')
                ->name('edit')
                ->middleware('permission:permissions.update')
                ->breadcrumbs(fn (Trail $trail, \Spatie\Permission\Models\Permission $permission) => $trail->parent('permissions.index')->push($permission->name, route('permissions.edit', $permission))
                );
            Route::post('update', 'update')
                ->name('update')
                ->middleware('permission:permissions.update');
            Route::post('delete', 'delete')
                ->name('delete')
                ->middleware('permission:permissions.delete');
        });
    });
});

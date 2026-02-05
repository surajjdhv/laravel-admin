<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Model::unguard();

        View::composer('*', function ($view) {
            $view->with('loggedInUser', auth()->user());
        });

        Gate::define('viewLogViewer', function ($user): bool {
            return $user?->can('log-viewer.view') ?? false;
        });
    }
}

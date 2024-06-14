<?php

namespace App\Providers;

// use Illuminate\Support\ServiceProvider;
namespace App\Providers;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

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
        //
        Route::middlewareGroup('api', [
            // ...
            \Illuminate\Session\Middleware\StartSession::class,
        ]);
    }
}

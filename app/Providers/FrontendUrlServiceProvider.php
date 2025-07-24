<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class FrontendUrlServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot()
    {
        // Share globally with all views
        View::share('FRONTEND_URL', 'https://bestdreamcar.com');

        // Bind to the service container (optional, for use in code)
        $this->app->singleton('frontend.url', function () {
            return 'https://bestdreamcar.com';
        });
    }
}

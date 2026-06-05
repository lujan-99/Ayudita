<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL; // <--- AGREGA ESTA LÍNEA

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
        // Esto soluciona que los assets (CSS/JS) carguen con https
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }
    }
}
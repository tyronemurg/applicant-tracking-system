<?php

namespace App\Providers\Filament;

use Illuminate\Support\ServiceProvider;

class FilamentServiceProvider extends ServiceProvider
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
        $this->publishes([
            base_path('vendor/filament/filament/resources/views') => resource_path('views/filament'),
        ], 'filament-views');
    }
}

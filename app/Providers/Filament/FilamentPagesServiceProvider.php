<?php

namespace App\Providers\Filament;

use Illuminate\Support\ServiceProvider;

class FilamentPagesServiceProvider extends ServiceProvider
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
            base_path('vendor/filament/filament/src/Pages') => app_path('Filament/Pages'),
        ], 'filament-pages');
    }
}

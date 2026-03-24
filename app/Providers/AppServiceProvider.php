<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Model; // <--- ESTA IMPORTACIÓN ES VITAL

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Déjalo vacío
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // 1. Prevenir carga perezosa (N+1) excepto en producción
        Model::preventLazyLoading(!app()->isProduction());
    }
}
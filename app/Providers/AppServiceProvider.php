<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

// Importaciones de la entidad Cliente (Módulo de Ventas - Esteban)
use App\Interfaces\ClienteInterface;
use App\Repositories\ClienteRepository;
use App\Interfaces\ProveedorInterface;
use App\Repositories\ProveedorRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Vinculación de la entidad Cliente con su Repositorio correspondiente
        $this->app->bind(ClienteInterface::class, ClienteRepository::class);
        $this ->app->bind(ProveedorInterface::class, ProveedorRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}

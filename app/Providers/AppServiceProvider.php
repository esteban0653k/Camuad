<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

// Importaciones de la entidad Cliente (Módulo de Ventas - Esteban)
use App\Interfaces\ClienteInterface;
use App\Repositories\ClienteRepository;

// Importaciones de la entidad Marca (Carlitos :P)
use App\Interfaces\MarcaRepositoryInterface;
use App\Repositories\MarcaRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // 1. Vinculación de la entidad Cliente con su Repositorio
        $this->app->bind(ClienteInterface::class, ClienteRepository::class);

        // 2. Vinculación de la entidad Marca con su Repositorio
        $this->app->bind(MarcaRepositoryInterface::class, MarcaRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}

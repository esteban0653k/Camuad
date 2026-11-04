<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

// Importaciones de Interfaces y Repositorios
use App\Interfaces\ClienteInterface;
use App\Repositories\ClienteRepository;
use App\Interfaces\ProveedorInterface;
use App\Repositories\ProveedorRepository;
use App\Interfaces\FacturaInterface;
use App\Repositories\FacturaRepository;

use App\Interfaces\CategoriasInterface;
use App\Repositories\CategoriasRepository;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(ClienteInterface::class, ClienteRepository::class);
        $this->app->bind(MarcaInterface::class, MarcaRepository::class);
        $this->app->bind(CategoriasInterface::class, CategoriasRepository::class);
    }

    public function boot(): void
    {
        
    }
}
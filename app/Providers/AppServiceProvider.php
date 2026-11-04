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

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(ClienteInterface::class, ClienteRepository::class);
        $this->app->bind(ProveedorInterface::class, ProveedorRepository::class);
        $this->app->bind(FacturaInterface::class, FacturaRepository::class);
    }

    public function boot(): void
    {
        
    }
}
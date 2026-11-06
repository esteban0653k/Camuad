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
use App\Interfaces\MarcaInterface;
use App\Repositories\MarcaRepository;
use App\Interfaces\ProductoInterface;
use App\Repositories\ProductoRepository;
use App\Interfaces\DetalleVentaInterface;
use App\Repositories\DetalleVentaRepository;
use App\Interfaces\UsuarioInterface;
use App\Repositories\UsuarioRepository;
use App\Interfaces\RolInterface;
use App\Repositories\RolRepository;
use App\Interfaces\EstadisticaInterface;
use App\Repositories\EstadisticaRepository;
use App\Interfaces\ReporteInterface;
use App\Repositories\ReporteRepository;
use App\Interfaces\StockInterface;
use App\Repositories\StockRepository;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(ClienteInterface::class, ClienteRepository::class);
        $this->app->bind(ProveedorInterface::class, ProveedorRepository::class);
        $this->app->bind(StockInterface::class, StockRepository::class);
        $this->app->bind(ProveedorInterface::class, ProveedorRepository::class);
        $this->app->bind(FacturaInterface::class, FacturaRepository::class);
        $this->app->bind(MarcaInterface::class, MarcaRepository::class);
        $this->app->bind(CategoriasInterface::class, CategoriasRepository::class);
        $this->app->bind(ProductoInterface::class, ProductoRepository::class);
        $this->app->bind(DetalleVentaInterface::class, DetalleVentaRepository::class);
        $this->app->bind(UsuarioInterface::class, UsuarioRepository::class);
        $this->app->bind(RolInterface::class, RolRepository::class);
        $this->app->bind(EstadisticaInterface::class, EstadisticaRepository::class);
        $this->app->bind(ReporteInterface::class, ReporteRepository::class);
    }

    public function boot(): void
    {
        
    }
}
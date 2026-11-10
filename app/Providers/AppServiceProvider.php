<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

// Importaciones de Interfaces y Repositorios
use App\Interfaces\ClienteInterface;
use App\Repositories\ClienteRepository;
use App\Interfaces\ProveedorInterface;
use App\Repositories\ProveedorRepository;
use App\Interfaces\VentaInterface;
use App\Repositories\VentaRepository;
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
use App\Interfaces\MovimientoInterface;
use App\Interfaces\TipoMovimientoInterface;
use App\Repositories\MovimientoRepository;
use App\Repositories\TipoMovimientoRepository;
use App\Interfaces\CompraProveedorInterface;
use App\Repositories\CompraProveedorRepository;
use App\Interfaces\DetalleCompraInterface;
use App\Repositories\DetalleCompraRepository;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(ClienteInterface::class, ClienteRepository::class);
        $this->app->bind(ProveedorInterface::class, ProveedorRepository::class);
        $this->app->bind(ProveedorInterface::class, ProveedorRepository::class);
        $this->app->bind(VentaInterface::class, VentaRepository::class);
        $this->app->bind(MarcaInterface::class, MarcaRepository::class);
        $this->app->bind(CategoriasInterface::class, CategoriasRepository::class);
        $this->app->bind(ProductoInterface::class, ProductoRepository::class);
        $this->app->bind(DetalleVentaInterface::class, DetalleVentaRepository::class);
        $this->app->bind(UsuarioInterface::class, UsuarioRepository::class);
        $this->app->bind(CompraProveedorInterface::class, CompraProveedorRepository::class);
        $this->app->bind(DetalleCompraInterface::class, DetalleCompraRepository::class);
        $this->app->bind(RolInterface::class, RolRepository::class);
        $this->app->bind(MovimientoInterface::class, MovimientoRepository::class);
        $this->app->bind(TipoMovimientoInterface::class, TipoMovimientoRepository::class);
    }

    public function boot(): void
    {
        
    }
}
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoriasController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\CompraProveedorController;
use App\Http\Controllers\DetalleCompraController;
use App\Http\Controllers\DetalleVentaController;
use App\Http\Controllers\EstadisticasController;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\MovimientoController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\TipoMovimientoController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\ProductoImagenController;
use App\Http\Controllers\ReposicionController;

Route::prefix('v1')->group(function () {

    // ==========================================
    // 1. RUTAS PÚBLICAS (No requieren token)
    // ==========================================
    Route::post('auth/login', [AuthController::class, 'login']);

    // ==========================================
    // 2. RUTAS PROTEGIDAS (Exigen Token JWT)
    // ==========================================
    Route::middleware('auth:api')->group(function () {
        // Sesión JWT
        Route::post('auth/logout', [AuthController::class, 'logout']);
        Route::post('auth/refresh', [AuthController::class, 'refresh']);
        Route::get('auth/me', [AuthController::class, 'me']);

        // Clientes
        Route::get('clientes/buscar', [ClienteController::class, 'getNombre']);
        Route::apiResource('clientes', ClienteController::class);

        // Proveedores
        Route::get('proveedores/nombre/{name}', [ProveedorController::class, 'findByName']);
        Route::get('proveedores/correo/{correo}', [ProveedorController::class, 'findByCorreo']);
        Route::apiResource('proveedores', ProveedorController::class);

        // Catálogos e Inventario
        Route::apiResource('categorias', CategoriasController::class);
        Route::apiResource('marcas', MarcaController::class);
        Route::apiResource('productos', ProductoController::class);

        // Ventas y Compras
        Route::apiResource('ventas', VentaController::class);
        Route::apiResource('detalles-venta', DetalleVentaController::class);
        Route::apiResource('compras', CompraProveedorController::class);
        Route::apiResource('detalles-compra', DetalleCompraController::class);

        // Kardex / Movimientos
        Route::apiResource('tipos-movimiento', TipoMovimientoController::class);
        Route::apiResource('movimientos', MovimientoController::class);

        // Administrador y supervisor: estadísticas, imágenes y reposición de stock
        Route::middleware('role:administrador,supervisor')->group(function () {
            Route::get('estadisticas', [EstadisticasController::class, 'index']);
            Route::post('productos/{sku}/imagen', ProductoImagenController::class);
            Route::post('productos/{sku}/reposicion', ReposicionController::class);
        });

        // Solo administrador: crear cuentas, usuarios y roles
        Route::middleware('role:administrador')->group(function () {
            Route::post('auth/register', [AuthController::class, 'register']);
            Route::apiResource('roles', RolController::class);
            Route::apiResource('usuarios', UsuarioController::class);
        });
    });
});
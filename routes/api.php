<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\CategoriasController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\DetalleVentaController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\CompraProveedorController;
use App\Http\Controllers\DetalleCompraController;


Route::prefix('v1')->group(function () {
    
// Api Compra Proveedor
    Route::get("compra_proveedor/pendientes", [CompraProveedorController::class, "listarPendientes"]);
    Route::get("compra_proveedor/estado/{estado}", [CompraProveedorController::class, "listarPorEstado"]);
    Route::get("compra_proveedor/proveedor/{nitProveedor}", [CompraProveedorController::class, "listarPorProveedor"]);
    Route::get("compra_proveedor/{id}/detalles", [CompraProveedorController::class, "obtenerConDetalles"]);
    Route::apiResource('compra_proveedor', CompraProveedorController::class);

    // Api Detalle Compra
    Route::get("detalle_compra/compra/{idCompra}", [DetalleCompraController::class, "listarPorCompra"]);
    Route::get("detalle_compra/sku/{sku}", [DetalleCompraController::class, "listarPorSku"]);
    Route::apiResource('detalle_compra', DetalleCompraController::class);

// Api Proveedores
    Route::apiResource('proveedores', ProveedorController::class);
    Route::get('proveedores/nombre/{name}', [ProveedorController::class, 'findByName']);
    Route::get('proveedores/correo/{correo}', [ProveedorController::class, 'findByCorreo']);

    // Api Clientes
    Route::get('clientes/buscar', [ClienteController::class, 'getNombre']);
    Route::apiResource('clientes', ClienteController::class);

    // Api Stock
    Route::get('stock/activos', [StockController::class, 'listarStockActivo']);
    Route::post('stock/verificar-alertas', [StockController::class, 'verificarAlertasManual']);
    Route::get('stock/fecha/{fecha}', [StockController::class, 'findFechaCompra']);
    Route::apiResource('stock', StockController::class);

    // Api Marcas
    Route::get('marcas/buscar', [MarcaController::class, 'buscar']);
    Route::apiResource('marcas', MarcaController::class);

    // Api Categorías
    Route::get('categorias/con-productos', [CategoriasController::class, 'conProductos']);
    Route::apiResource('categorias', CategoriasController::class);

    // Api Productos
    Route::get('productos/buscar', [ProductoController::class, 'buscarPorNombre']);
    Route::patch('productos/{sku}/descontar-stock', [ProductoController::class, 'descontarStock']);
    Route::apiResource('productos', ProductoController::class);
    Route::patch('productos/{sku}/reabastecer-stock', [ProductoController::class, 'reabastecerStock']);

    // Api Ventas
    Route::apiResource('ventas', VentaController::class);

    // Api Detalle Venta (solo lectura y cambio de estado)
    Route::apiResource('detalles-venta', DetalleVentaController::class)
        ->only(['index', 'show', 'update']);

    // Api Usuarios
    Route::apiResource('usuarios', UsuarioController::class);

    // Api Roles
    Route::apiResource('roles', RolController::class);
});
<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\CategoriasController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\FacturaController;
use App\Http\Controllers\DetalleVentaController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\SolicitudStockController;


Route::prefix('v1')->group(function(){
    // Api Proveedores
    Route::apiResource('proveedores', ProveedorController::class);  
    Route::get("proveedores/nombre/{name}", [ProveedorController::class, "findByName"]);
    Route::get("proveedores/correo/{correo}", [ProveedorController::class, "findByCorreo"]);

    // Api Clientes
    Route::get('clientes/buscar', [ClienteController::class, 'getNombre']);
Route::apiResource('clientes', ClienteController::class);

//Api Stock
    Route::get("stock/activos", [StockController::class, "listarStockActivo"]);
    Route::post("stock/verificar-alertas", [StockController::class, "verificarAlertasManual"]);
    Route::get("stock/fecha/{fecha}", [StockController::class, "findFechaCompra"]);

    Route::apiResource('stock', StockController::class);

    // Api Marcas
    Route::get('marcas/buscar', [MarcaController::class, 'buscar']);
    Route::apiResource('marcas', MarcaController::class);

    // Api Categorías
    Route::get('categorias/con-productos', [CategoriasController::class, 'conProductos']);
    Route::apiResource('categorias', CategoriasController::class);

    //Api productos
    Route::get('productos/buscar', [ProductoController::class, 'buscarPorNombre']);
    Route::apiResource('productos', ProductoController::class);

    // Api Facturas
    Route::apiResource('facturas', FacturaController::class);

    // Api Detalle Venta
    Route::apiResource('detalles-venta', DetalleVentaController::class);

    //Api Solicitud Stock
    Route::apiResource('solicitud_stock', SolicitudStockController::class);

});
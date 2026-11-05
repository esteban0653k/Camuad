<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProveedorController;

Route::prefix('v1')->group(function(){
    //Api proveedores
    Route::apiResource('proveedores', ProveedorController::class);
    Route::get("proveedores/nombre/{name}", [ProveedorController::class, "findByName"]);
    Route::get("proveedores/correo/{correo}", [ProveedorController::class, "findByCorreo"]);
  
     //Api Clientes
    Route::apiResource('clientes', ClienteController::class);
    Route::get('clientes/buscar', [ClienteController::class, 'getNombre']);

    //Api Stock
    Route::apiResource('stock', StockController::class);
    Route::get("stock/activos", [StockController::class, "listarStockActivo"]);
    Route::post("stock/verificar-alertas", [StockController::class, "verificarAlertasManual"]);
    Route::get("stock/fecha/{fecha}", [StockController::class, "findFechaCompra"]);
});



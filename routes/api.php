<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\FacturaController;

Route::prefix('v1')->group(function(){
    // Api Proveedores
    Route::apiResource('proveedores', ProveedorController::class);  
    Route::get("proveedores/nombre/{name}", [ProveedorController::class, "findByName"]);
    Route::get("proveedores/correo/{correo}", [ProveedorController::class, "findByCorreo"]);
    // Api Clientes
    // La ruta de búsqueda debe ir ANTES del apiResource para que Laravel no confunda 'buscar' con un ID (show)
    Route::get('clientes/buscar', [ClienteController::class, 'getNombre']);
    Route::apiResource('clientes', ClienteController::class);

    // Api Facturas
    Route::apiResource('facturas', FacturaController::class);
});



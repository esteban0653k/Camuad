<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\CategoriasController;

Route::prefix('v1')->group(function(){
    //Api proveedores
    Route::apiResource('proveedores', ProveedorController::class);
    Route::get("proveedores/nombre/{name}", [ProveedorController::class, "findByName"]);
    Route::get("proveedores/correo/{correo}", [ProveedorController::class, "findByCorreo"]);
  
     //Api Clientes
    Route::apiResource('clientes', ClienteController::class);
    Route::get('clientes/buscar', [ClienteController::class, 'getNombre']);

    //Api marcas
    Route::get('marcas/buscar', [MarcaController::class, 'buscar']);
    Route::apiResource('marcas', MarcaController::class);

    //Api categorias
    Route::get('categorias/con-productos', [CategoriasController::class, 'conProductos']);
    Route::apiResource('categorias', CategoriasController::class);
});



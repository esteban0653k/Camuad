<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProveedorController;

Route::prefix('v1')->group(function(){
    Route::apiResource('proveedores', ProveedorController::class);
    Route::get("proveedores/nombre/{name}", [ProveedorController::class, "findByName"]);
    Route::get("proveedores/correo/{correo}", [ProveedorController::class, "findByCorreo"]);
});

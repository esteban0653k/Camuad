<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProveedorController;

Route::prefix('v1')->group(function(){
    Route::apiResource('proveedor', ProveedorController::class);
    Route::get("proveedor/nombre/{name}", [ProveedorController::class, "findByName"]);
    Route::get("rol/correo/{correo}", [ProveedorController::class, "findByCorreo"]);
});

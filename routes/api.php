<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\RolController;

Route::apiResource('usuarios', UsuarioController::class);
Route::apiResource('roles', RolController::class);
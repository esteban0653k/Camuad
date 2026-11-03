<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;

// Rutas de la API para el módulo de ventas
Route::apiResource('clientes', ClienteController::class);
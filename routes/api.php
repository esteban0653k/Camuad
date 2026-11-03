<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;

//Api Clientes
Route::apiResource('clientes', ClienteController::class);
Route::get('clientes/buscar', [ClienteController::class, 'getNombre']);
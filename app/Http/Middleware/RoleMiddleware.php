<?php

namespace App\Http\Middleware;

use App\Models\Rol;
use Closure;
use Illuminate\Http\Request;

/** Uso en rutas: ->middleware('role:administrador,supervisor') */
class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string ...$roles)
    {
        $user = auth('api')->user();
        $rol = $user ? strtolower(Rol::find($user->role_id)?->nombre ?? '') : '';

        if (!in_array($rol, $roles, true)) {
            return response()->json(['message' => 'No tienes permiso para esta acción.'], 403);
        }
        return $next($request);
    }
}
<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = $request->validated();

        if (! $token = auth('api')->attempt($credentials)) {
            throw ValidationException::withMessages([
                'email' => ['Credenciales inválidas.'],
            ]);
        }

        return $this->respondWithToken($token);
    }

    public function me(): JsonResponse
    {
        $user = auth('api')->user();

        if (! $user) {
            return response()->json([
                'message' => 'Usuario no encontrado',
            ], 404);
        }

        $user->loadMissing('rol');

        return response()->json([
            'user'        => $user,
            'rol'         => method_exists($user, 'getRoleName') ? $user->getRoleName() : null,
            'permissions' => method_exists($user, 'getPermissions') ? $user->getPermissions() : [],
        ], 200);
    }

    public function logout(): JsonResponse
    {
        try {
            auth('api')->logout();

            return response()->json([
                'message' => 'Sesión cerrada correctamente.',
            ], 200);
        } catch (JWTException $e) {
            return response()->json([
                'message' => 'No se pudo cerrar la sesión o el token es inválido.',
            ], 401);
        }
    }

    public function refresh(): JsonResponse
    {
        try {
            return $this->respondWithToken(auth('api')->refresh());
        } catch (JWTException $e) {
            return response()->json([
                'message' => 'No se pudo refrescar el token.',
            ], 401);
        }
    }

    protected function respondWithToken(string $token): JsonResponse
    {
        $user = auth('api')->user();

        if (! $user) {
            return response()->json([
                'message' => 'Usuario no autenticado',
            ], 401);
        }

        $user->loadMissing('rol');

        return response()->json([
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => auth('api')->factory()->getTTL() * 60,
            'user'         => [
                'id'          => $user->getKey(),
                'nombre'      => $user->nombre ?? $user->name,
                'email'       => $user->email,
                'rol'         => method_exists($user, 'getRolNombre') ? $user->getRolNombre() : null,
                'permissions' => method_exists($user, 'getPermissions') ? $user->getPermissions() : [],
            ],
        ], 200);
    }
}
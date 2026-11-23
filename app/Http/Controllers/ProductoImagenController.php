<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductoImagenController extends Controller
{
    public function __invoke(Request $request, string $sku): JsonResponse
    {
        $request->validate([
            'imagen' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            'imagen.max'   => 'La imagen no puede pesar más de 2 MB.',
            'imagen.image' => 'El archivo debe ser una imagen JPG, PNG o WEBP.',
        ]);

        $producto = Producto::where('sku', $sku)->firstOrFail();
        if ($producto->imagen) {
            Storage::disk('public')->delete($producto->imagen);
        }

        $path = $request->file('imagen')->store('productos', 'public');
        Producto::where('sku', $sku)->update(['imagen' => $path]);

        return response()->json(['data' => ['sku' => $sku, 'imagen' => $path]]);
    }
}
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $skuActual = $this->route('producto'); 

        return [
            'sku' => 'required|string|max:100|unique:producto,sku,' . $skuActual . ',sku',
            'nombre_producto' => 'required|string|max:255',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'descripcion' => 'nullable|string',
            'id_categoria' => 'required|exists:categorias,id',
            'id_marca' => 'required|exists:marcas,id_marca',];
    }

    public function messages(): array
    {
        return [
            'sku.required' => 'El código SKU es obligatorio.',
            'sku.unique' => 'Este código SKU ya se encuentra registrado.',
            'nombre_producto.required' => 'El nombre del producto es obligatorio.',
            'precio.required' => 'El precio es obligatorio.',
            'stock.required' => 'El stock es obligatorio.',
            'id_categoria.required' => 'Debe seleccionar una categoría.',
            'id_marca.required' => 'Debe seleccionar una marca.',
        ];
    }
}
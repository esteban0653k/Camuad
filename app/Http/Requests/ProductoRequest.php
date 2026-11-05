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
        $productoId = $this->route('producto');

        return [
            'nombre_producto' => 'required|string|max:255',
            'sku' => 'required|string|max:100|unique:productos,sku,' . $productoId . ',id_producto',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'descripcion' => 'nullable|string',
            'id_categoria' => 'required|exists:categorias,id',
            'id_marca' => 'required|exists:marca,id_marca',
        ];
    }

    public function messages(): array
    {
        return [
            'nombre_producto.required' => 'El nombre del producto es obligatorio.',
            'nombre_producto.string' => 'El nombre del producto debe ser una cadena de texto.',
            'nombre_producto.max' => 'El nombre del producto no puede exceder los 255 caracteres.',
            
            'sku.required' => 'El código SKU es obligatorio.',
            'sku.string' => 'El SKU debe ser una cadena de texto.',
            'sku.max' => 'El SKU no puede exceder los 100 caracteres.',
            'sku.unique' => 'Este código SKU ya se encuentra registrado en otro producto.',
            
            'precio.required' => 'El precio del producto es obligatorio.',
            'precio.numeric' => 'El precio debe ser un valor numérico.',
            'precio.min' => 'El precio no puede ser un número negativo.',
            
            'stock.required' => 'La cantidad de stock es obligatoria.',
            'stock.integer' => 'El stock debe ser un número entero.',
            'stock.min' => 'El stock no puede ser un número negativo.',
            
            'id_categoria.required' => 'Debe seleccionar una categoría obligatoriamente.',
            'id_categoria.exists' => 'La categoría seleccionada no es válida o no existe.',
            
            'id_marca.required' => 'Debe seleccionar una marca obligatoriamente.',
            'id_marca.exists' => 'La marca seleccionada no es válida o no existe.',
        ];
    }
}
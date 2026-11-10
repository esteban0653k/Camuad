<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DetalleCompraRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $isUpdate = $this->isMethod('PUT') || $this->isMethod('PATCH');

        return [
            'id_compra' => [
                $isUpdate ? 'sometimes' : 'required',
                'integer',
                'exists:compra_proveedor,id_compra',
            ],
            'sku_producto' => [
                $isUpdate ? 'sometimes' : 'required',
                'string',
                'max:50',
                'exists:productos,sku',
            ],
            'cantidad_solicitada' => [
                $isUpdate ? 'sometimes' : 'required',
                'integer',
                'min:1',
            ],
            'costo_unitario' => [
                $isUpdate ? 'sometimes' : 'required',
                'numeric',
                'min:0',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'id_compra.required' => 'La compra es obligatoria.',
            'id_compra.integer' => 'El identificador de la compra debe ser un número entero.',
            'id_compra.exists' => 'La compra especificada no existe registrada en el sistema.',

            'sku_producto.required' => 'El código SKU del producto es obligatorio.',
            'sku_producto.string' => 'El SKU del producto debe ser una cadena de texto.',
            'sku_producto.max' => 'El SKU no puede exceder los 50 caracteres.',
            'sku_producto.exists' => 'El SKU especificado no existe registrado en el sistema.',

            'cantidad_solicitada.required' => 'La cantidad solicitada es obligatoria.',
            'cantidad_solicitada.integer' => 'La cantidad solicitada debe ser un número entero.',
            'cantidad_solicitada.min' => 'La cantidad solicitada debe ser al menos 1.',

            'costo_unitario.required' => 'El costo unitario es obligatorio.',
            'costo_unitario.numeric' => 'El costo unitario debe ser un valor numérico.',
            'costo_unitario.min' => 'El costo unitario no puede ser menor a 0.',
        ];
    }
}

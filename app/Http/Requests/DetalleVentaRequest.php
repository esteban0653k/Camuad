<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DetalleVentaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $isUpdate = $this->isMethod('PUT') || $this->isMethod('PATCH');

        return [
            'id_venta' => [
                $isUpdate ? 'sometimes' : 'required',
                'integer',
                'exists:venta,id_venta',
            ],
            'sku_producto' => [
                $isUpdate ? 'sometimes' : 'required',
                'string',
                'exists:producto,sku',
            ],
            'cantidad' => [
                $isUpdate ? 'sometimes' : 'required',
                'integer',
                'min:1',
            ],
            'precio_unitario' => [
                $isUpdate ? 'sometimes' : 'required',
                'numeric',
                'min:0',
            ],
            'estado_venta' => [
                'sometimes',
                'string',
                'max:50',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'id_venta.exists'           => 'La venta especificada no existe.',
            'id_venta.required'         => 'El ID de la venta es obligatorio.',
            'sku_producto.exists'       => 'El producto especificado no existe.',
            'sku_producto.required'     => 'El SKU del producto es obligatorio.',
            'cantidad.required'         => 'La cantidad es obligatoria.',
            'cantidad.min'              => 'La cantidad mínima debe ser al menos 1.',
            'precio_unitario.required'  => 'El precio unitario es obligatorio.',
            'precio_unitario.min'       => 'El precio unitario no puede ser negativo.',
        ];
    }
}
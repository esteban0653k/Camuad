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
            'id_factura' => [
                $isUpdate ? 'sometimes' : 'required',
                'integer',
                'exists:factura,id_factura'
            ],
            'id_producto' => [
                $isUpdate ? 'sometimes' : 'required',
                'string',
                'exists:productos,sku'
            ],
            'cantidad' => [
                $isUpdate ? 'sometimes' : 'required',
                'integer',
                'min:1'
            ],
            'precio_unitario' => [
                $isUpdate ? 'sometimes' : 'required',
                'numeric',
                'min:0'
            ],
            'estado_venta' => [
                'required',
                'string',
                'max:50'
            ]
        ];
    }

    public function messages(): array 
    {
        return [
            'id_factura.exists'        => 'La factura especificada no existe.',
            'id_factura.required'      => 'El ID de la factura es obligatorio.',
            'id_producto.exists'       => 'El producto especificado no existe.',
            'id_producto.required'     => 'El ID del producto es obligatorio.',
            'cantidad.required'        => 'La cantidad es obligatoria.',
            'cantidad.min'             => 'La cantidad mínima debe ser al menos 1.',
            'precio_unitario.required' => 'El precio unitario es obligatorio.'
        ];
    }
}
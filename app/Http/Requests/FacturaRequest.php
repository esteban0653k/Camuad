<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FacturaRequest extends FormRequest 
{
    public function authorize(): bool 
    {
        return true;
    }

    public function rules(): array 
    {
        $isUpdate = $this->isMethod('PUT') || $this->isMethod('PATCH');

        return [
            'numero_documento_cliente' => [
                $isUpdate ? 'sometimes' : 'required',
                'string',
                'exists:cliente,numero_documento'
            ],
            'descuento' => [
                'nullable',
                'numeric',
                'min:0'
            ],
            'detalles' => [
                $isUpdate ? 'nullable' : 'required',
                'array',
                'min:1'
            ],
            'detalles.*.id_producto' => [
                'required_with:detalles',
                'string', // Coincide con el SKU del producto
                'exists:producto,sku'
            ],
            'detalles.*.cantidad' => [
                'required_with:detalles',
                'integer',
                'min:1'
            ],
            'detalles.*.precio_unitario' => [
                'required_with:detalles',
                'numeric',
                'min:0'
            ]
        ];
    }

    public function messages(): array 
    {
        return [
            'numero_documento_cliente.exists'   => 'El cliente especificado no existe.',
            'numero_documento_cliente.required' => 'El documento del cliente es obligatorio.',
            'detalles.required'                 => 'La factura debe contener al menos un detalle de venta.',
            'detalles.*.id_producto.exists'     => 'El producto especificado no existe en el inventario.',
            'detalles.*.cantidad.min'           => 'La cantidad mínima por producto debe ser al menos 1.'
        ];
    }
}
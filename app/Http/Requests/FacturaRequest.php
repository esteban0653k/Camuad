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
            'subtotal' => [
                $isUpdate ? 'sometimes' : 'required',
                'numeric',
                'min:0'
            ],
            'iva' => [
                $isUpdate ? 'sometimes' : 'required',
                'numeric',
                'min:0'
            ],
            'descuento' => [
                'nullable',
                'numeric',
                'min:0'
            ],
            'total' => [
                $isUpdate ? 'sometimes' : 'required',
                'numeric',
                'min:0'
            ],
            'detalles' => [
                'nullable',
                'array'
            ],
            'detalles.*.id_producto' => [
                'required_with:detalles',
                'integer'
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
            'numero_documento_cliente.exists'   => 'El cliente especificado no se encuentra registrado.',
            'numero_documento_cliente.required' => 'El documento del cliente es obligatorio.',
            'subtotal.required'                 => 'El subtotal es obligatorio.',
            'iva.required'                      => 'El IVA es obligatorio.',
            'total.required'                    => 'El valor total de la factura es obligatorio.'
        ];
    }
}
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MovimientoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'sku_producto' => [
                'nullable',
                'string',
                'exists:producto,sku',
            ],
            'id_tipo_movimiento' => [
                'nullable',
                'integer',
                'exists:tipo_movimiento,id_tipo_movimiento',
            ],
            'id_venta' => [
                'nullable',
                'integer',
                'exists:venta,id_venta',
            ],
            'id_compra' => [
                'nullable',
                'integer',
                'exists:compra_proveedor,id_compra',
            ],
            'desde' => [
                'nullable',
                'date',
            ],
            'hasta' => [
                'nullable',
                'date',
                'after_or_equal:desde',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'sku_producto.exists'       => 'El producto especificado no existe.',
            'id_tipo_movimiento.exists' => 'El tipo de movimiento especificado no existe.',
            'id_venta.exists'           => 'La venta especificada no existe.',
            'id_compra.exists'          => 'La compra especificada no existe.',
            'desde.date'                => 'La fecha "desde" no es válida.',
            'hasta.date'                => 'La fecha "hasta" no es válida.',
            'hasta.after_or_equal'      => 'La fecha "hasta" no puede ser anterior a "desde".',
        ];
    }
}
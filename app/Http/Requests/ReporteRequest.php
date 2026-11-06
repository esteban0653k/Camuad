<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReporteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $isUpdate = $this->isMethod('PUT') || $this->isMethod('PATCH');

        return [
            'tipo_reporte' => [
                $isUpdate ? 'sometimes' : 'required',
                'string',
                'max:100'
            ],
            'total_ingresos' => ['nullable', 'numeric', 'min:0'],
            'total_egresos' => ['nullable', 'numeric', 'min:0'],
            'ganancias' => ['nullable', 'numeric'],
            'producto_vendido' => ['nullable', 'string', 'max:100'],
            'cantidad_vendida' => ['nullable', 'integer', 'min:0'],
            'factura' => ['nullable', 'integer', 'exists:factura,id_factura'],
            'solicitud_stock' => ['nullable', 'integer', 'exists:solicitud_stock,id_solicitud_reposicion']
        ];
    }

    public function messages(): array
    {
        return [
            'tipo_reporte.required' => 'El tipo de reporte es obligatorio.',
            'factura.exists' => 'La factura especificada no existe.',
            'solicitud_stock.exists' => 'La solicitud de stock especificada no existe.'
        ];
    }
}
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EstadisticaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // Detectamos si es una petición de actualización (PUT o PATCH)
        $isUpdate = $this->isMethod('PUT') || $this->isMethod('PATCH');

        return [
            'tipo_estadistica' => [
                $isUpdate ? 'sometimes' : 'required',
                'string',
                'max:100'
            ],
            'id_reporte' => [
                'nullable',
                'integer',
                'exists:reporte,id_reporte' // Valida que exista en la tabla reporte
            ],
            'stock' => [
                'nullable',
                'integer',
                'exists:stock,id_compra' // Valida que exista en la tabla stock (id_compra)
            ]
        ];
    }

    public function messages(): array
    {
        return [
            'tipo_estadistica.required' => 'El tipo de estadística es obligatorio.',
            'id_reporte.exists'         => 'El reporte especificado no existe en el sistema.',
            'stock.exists'              => 'El registro de stock especificado no existe.'
        ];
    }
}
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SolicitudStockRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $isUpdate = $this->isMethod('PUT') || $this->isMethod('PATCH');

        return [
            'fecha_solicitud' => [
                $isUpdate ? 'sometimes' : 'required',
                'date',
            ],
            'prioridad' => [
                $isUpdate ? 'sometimes' : 'required',
                'in:alta,media,baja',
            ],
            'costo_unitario' => [
                $isUpdate ? 'sometimes' : 'required',
                'numeric',
                'min:0',
            ],
            'total_compra' => [
                $isUpdate ? 'sometimes' : 'required',
                'numeric',
                'min:0',
            ],
            'cantidad_comprar' => [
                $isUpdate ? 'sometimes' : 'required',
                'integer',
                'min:1',
            ],
            'nit_proveedor' => [
                $isUpdate ? 'sometimes' : 'required',
                'string',
                'max:50',
                'exists:proveedor,nit_proveedor', 
            ],
            'stock' => [
                $isUpdate ? 'sometimes' : 'required',
                'integer',
                'exists:stock,id_compra', 
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'fecha_solicitud.required' => 'La fecha de solicitud es obligatoria.',
            'fecha_solicitud.date' => 'La fecha de solicitud debe ser una fecha válida.',

            'prioridad.required' => 'La prioridad es obligatoria.',
            'prioridad.in' => 'La prioridad debe ser una de las siguientes: alta, media, baja.',

            'costo_unitario.required' => 'El costo unitario es obligatorio.',
            'costo_unitario.numeric' => 'El costo unitario debe ser un valor numérico.',
            'costo_unitario.min' => 'El costo unitario no puede ser menor a 0.',

            'total_compra.required' => 'El total de la compra es obligatorio.',
            'total_compra.numeric' => 'El total de la compra debe ser un valor numérico.',
            'total_compra.min' => 'El total de la compra no puede ser menor a 0.',

            'cantidad_comprar.required' => 'La cantidad a comprar es obligatoria.',
            'cantidad_comprar.integer' => 'La cantidad a comprar debe ser un número entero.',
            'cantidad_comprar.min' => 'La cantidad a comprar debe ser al menos 1.',

            'nit_proveedor.required' => 'El NIT del proveedor es obligatorio.',
            'nit_proveedor.exists' => 'El NIT del proveedor especificado no existe en el sistema.',

            'stock.required' => 'El identificador de stock es obligatorio.',
            'stock.integer' => 'El stock debe ser un número entero.',
            'stock.exists' => 'El registro de stock especificado no existe en el sistema.',
        ];
    }
}

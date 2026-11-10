<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompraProveedorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $isUpdate = $this->isMethod('PUT') || $this->isMethod('PATCH');

        return [
            'fecha_compra' => [
                $isUpdate ? 'sometimes' : 'required',
                'date',
            ],
            'estado' => [
                $isUpdate ? 'sometimes' : 'required',
                'in:pendiente,enviada,recibida,cancelada',
            ],
            'nit_proveedor' => [
                $isUpdate ? 'sometimes' : 'required',
                'string',
                'max:20',
                'exists:proveedor,nit_proveedor',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'fecha_compra.required' => 'La fecha de compra es obligatoria.',
            'fecha_compra.date' => 'La fecha de compra debe ser un formato de fecha válido.',

            'estado.required' => 'El estado es obligatorio.',
            'estado.in' => 'El estado debe ser uno de los siguientes: pendiente, enviada, recibida, cancelada.',

            'nit_proveedor.required' => 'El NIT del proveedor es obligatorio.',
            'nit_proveedor.string' => 'El NIT del proveedor debe ser una cadena de texto.',
            'nit_proveedor.max' => 'El NIT del proveedor no puede exceder los 20 caracteres.',
            'nit_proveedor.exists' => 'El proveedor especificado no existe registrado en el sistema.',
        ];
    }
}
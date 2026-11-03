<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RequestProveedor extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $isUpdate = $this->isMethod('PUT') || $this->isMethod('PATCH');
        
        // Captura el nit del proveedor desde la ruta de manera segura
        $proveedorNit = $this->route('proveedor') ?? $this->route('nit'); 

        return [
            'nit_provvedor' => [
                $isUpdate ? 'sometimes' : 'required',
                'string',
                'max:50',
                Rule::unique('proveedores', 'nit_provvedor')->ignore($proveedorNit, 'nit_provvedor')
            ],
            'nombre_proveedor' => [
                $isUpdate ? 'sometimes' : 'required',
                'string',
                'max:255',
            ],
            'telefono' => [
                'nullable',
                'string',
                'max:20',
            ],
            'correo_proveedor' => [
                'required',
                'email',
                'max:255',
                Rule::unique('proveedores', 'correo_proveedor')->ignore($proveedorNit, 'nit_provvedor')
            ],
            'direccion' => [
                'nullable',
                'string',
                'max:255',
            ]
        ];
    }

    public function messages(): array
    {
        return [
            'nit_provvedor.required' => 'El NIT del proveedor es obligatorio.',
            'nit_provvedor.unique' => 'Este NIT ya se encuentra registrado.',
            
            'nombre_proveedor.required' => 'El nombre del proveedor es obligatorio.',
            'nombre_proveedor.string' => 'El nombre debe ser texto.',
            'nombre_proveedor.max' => 'El nombre no puede exceder los 255 caracteres.',

            'telefono.string' => 'El teléfono debe ser una cadena de texto válida.',
            'telefono.max' => 'El teléfono no puede exceder los 20 caracteres.',

            'correo_proveedor.required' => 'El correo electrónico es obligatorio.',
            'correo_proveedor.email' => 'Debe ingresar un correo electrónico válido.',
            'correo_proveedor.max' => 'El correo no puede exceder los 255 caracteres.',
            'correo_proveedor.unique' => 'Este correo ya está registrado por otro proveedor.',

            'direccion.string' => 'La dirección debe ser texto.',
            'direccion.max' => 'La dirección no puede exceder los 255 caracteres.',
        ];
    }
}
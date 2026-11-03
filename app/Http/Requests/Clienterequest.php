<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ClienteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $isUpdate = $this->isMethod('PUT') || $this->isMethod('PATCH');
        $numeroDocumento = $this->route('cliente') ?? $this->route('numero_documento');

        return [
            'numero_documento' => [
                $isUpdate ? 'sometimes' : 'required',
                'string',
                'max:50',
                Rule::unique('cliente', 'numero_documento')->ignore($numeroDocumento, 'numero_documento')
            ],
            'tipo_documento' => [
                $isUpdate ? 'sometimes' : 'required',
                'string',
                'max:20'
            ],
            'nombre' => [
                $isUpdate ? 'sometimes' : 'required',
                'string',
                'max:100'
            ],
            'correo' => [
                'nullable',
                'email',
                'max:150'
            ],
            'telefono' => [
                'nullable',
                'string',
                'max:20'
            ]
        ];
    }

    /**
     * Custom validation messages.
     */
    public function messages(): array
    {
        return [
            'numero_documento.required' => 'El número de documento es obligatorio.',
            'numero_documento.string'   => 'El número de documento debe ser una cadena de texto.',
            'numero_documento.max'      => 'El número de documento no puede exceder los 50 caracteres.',
            'numero_documento.unique'   => 'Este número de documento ya se encuentra registrado en el sistema.',

            'tipo_documento.required'   => 'El tipo de documento es obligatorio.',
            'tipo_documento.string'     => 'El tipo de documento debe ser una cadena de texto.',
            'tipo_documento.max'        => 'El tipo de documento no puede exceder los 20 caracteres.',

            'nombre.required'           => 'El nombre del cliente es obligatorio.',
            'nombre.string'             => 'El nombre debe ser una cadena de texto.',
            'nombre.max'                => 'El nombre no puede exceder los 100 caracteres.',

            'correo.email'              => 'El correo electrónico debe tener un formato válido.',
            'correo.max'                => 'El correo no puede exceder los 150 caracteres.',

            'telefono.string'           => 'El teléfono debe ser una cadena de texto.',
            'telefono.max'              => 'El teléfono no puede exceder los 20 caracteres.',
        ];
    }
}

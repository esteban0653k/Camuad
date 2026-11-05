<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UsuarioRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $isUpdate = $this->isMethod('PUT') || $this->isMethod('PATCH');
        $userId = $this->route('usuario'); 

        return [
            'nombre'   => $isUpdate ? 'sometimes|string|max:255' : 'required|string|max:255',
            'email'    => $isUpdate 
                            ? 'sometimes|email|unique:usuarios,email,' . $userId 
                            : 'required|email|unique:usuarios,email',
            'password' => $isUpdate ? 'nullable|string|min:8' : 'required|string|min:8',
            'role_id'  => $isUpdate ? 'sometimes|exists:roles,id' : 'required|exists:roles,id',
        ];
    } 

    public function messages(): array
    {
        return [
            'password.required' => 'La contraseña es obligatoria.',
            'password.min'      => 'La contraseña requiere 8 caracteres mínimos.',
            'email.unique'      => 'Este correo ya está registrado.',
            'email.required'    => 'El correo es obligatorio.',
            'nombre.required'   => 'El nombre es obligatorio.',
            'role_id.exists'    => 'El rol seleccionado no existe.',
        ];
    } 
} 
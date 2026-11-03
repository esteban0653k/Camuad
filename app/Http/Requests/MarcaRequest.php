<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MarcaRequest extends FormRequest {
    public function authorize(): bool {
        return true;
    }

    public function rules(): array {
        return [
            'nombre_marca' => 'required|string|max:100|unique:marca,nombre_marca'
        ];
    }

    public function messages(): array {
        return [
            'nombre_marca.required' => 'El nombre de la marca es obligatorio.',
            'nombre_marca.unique'   => 'Esta marca ya se encuentra registrada.'
        ];
    }
}

<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoriasRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $categoryId = $this->route('categoria');

        return [
            'nombre' => 'required|string|max:255|unique:categorias,nombre,' . $categoryId,
            'slug' => 'nullable|string|max:255|unique:categorias,slug,' . $categoryId,
            'descripcion' => 'nullable|string',
        ];
    }
    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre de la categoría es obligatorio.',
            'nombre.unique' => 'Ya existe una categoría registrada con este nombre.',
            'slug.unique' => 'El slug generado ya está en uso.',
        ];
    }
}
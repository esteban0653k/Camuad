<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StockRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $isUpdate = $this->isMethod('PUT') || $this->isMethod('PATCH');
        
        $stockId = $this->route('stock') ?? $this->route('id_compra'); 

        return [
            'fecha_compra' => [
                $isUpdate ? 'sometimes' : 'required',
                'date',
            ],
            'cantidad' => [
                'nullable',
                'integer',
                'min:0',
            ],
            'cantidad_min_stock' => [
                'nullable',
                'integer',
                'min:0',
            ],
            'estado' => [
                $isUpdate ? 'sometimes' : 'required',
                'in:activo,pendiente,inactivo',
            ],
            'producto' => [
                $isUpdate ? 'sometimes' : 'required',
                'string',
                'max:100',
                'exists:producto,sku',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'fecha_compra.required' => 'La fecha de compra es obligatoria.',
            'fecha_compra.date' => 'La fecha de compra debe ser un formato de fecha válido.',

            'cantidad.integer' => 'La cantidad debe ser un número entero.',
            'cantidad.min' => 'La cantidad no puede ser menor a 0.',

            'cantidad_min_stock.integer' => 'El stock mínimo debe ser un número entero.',
            'cantidad_min_stock.min' => 'El stock mínimo no puede ser menor a 0.',

            'estado.required' => 'El estado es obligatorio.',
            'estado.in' => 'El estado debe ser uno de los siguientes: activo, pendiente, inactivo.',

            'producto.required' => 'El código SKU del producto es obligatorio.',
            'producto.string' => 'El producto debe ser una cadena de texto.',
            'producto.max' => 'El SKU no puede exceder los 100 caracteres.',
            'producto.exists' => 'El SKU especificado no existe registrado en el sistema.',
        ];
    }
}
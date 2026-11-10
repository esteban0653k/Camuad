<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VentaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $isUpdate = $this->isMethod('PUT') || $this->isMethod('PATCH');

        return [
            'documento_cliente' => [
                $isUpdate ? 'sometimes' : 'required',
                'string',
                'exists:cliente,numero_documento',
            ],
            'metodo_pago' => [
                'nullable',
                'string',
                'max:50',
            ],
            'monto_recibido' => [
                'nullable',
                'numeric',
                'min:0',
            ],
            'descuento' => [
                'nullable',
                'numeric',
                'min:0',
            ],
            'detalles' => [
                $isUpdate ? 'prohibited' : 'required',
                'array',
                'min:1',
            ],
            'detalles.*.sku_producto' => [
                'required_with:detalles',
                'string',
                'exists:producto,sku',
            ],
            'detalles.*.cantidad' => [
                'required_with:detalles',
                'integer',
                'min:1',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'documento_cliente.exists'        => 'El cliente especificado no existe.',
            'documento_cliente.required'      => 'El documento del cliente es obligatorio.',
            'metodo_pago.string'              => 'El método de pago debe ser un texto válido.',
            'monto_recibido.numeric'          => 'El monto recibido debe ser un valor numérico.',
            'monto_recibido.min'              => 'El monto recibido no puede ser negativo.',
            'descuento.min'                   => 'El descuento no puede ser negativo.',
            'detalles.required'               => 'La venta debe contener al menos un detalle.',
            'detalles.prohibited'             => 'Los detalles de una venta no se pueden modificar desde aquí.',
            'detalles.*.sku_producto.required_with' => 'Cada detalle debe incluir el SKU del producto.',
            'detalles.*.sku_producto.exists'  => 'El producto especificado no existe en el inventario.',
            'detalles.*.cantidad.min'         => 'La cantidad mínima por producto debe ser al menos 1.',
        ];
    }
}
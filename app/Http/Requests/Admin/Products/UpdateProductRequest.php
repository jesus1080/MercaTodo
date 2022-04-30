<?php

namespace App\Http\Requests\Admin\Products;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends FormRequest
{
    public function authorizate(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

            'name' => 'required|string|max:255',
            'price' => 'required|between:0,9999999',
            'description' => 'required|string|max:255',
            'stock' => 'required|between:0,9999999',
            'image' => 'image|max:1200|nullable',
        ];
    }

    public function messages(): array
    {
        return [
        'name.required' => 'El nombre es un valor requerido',
        'min' => 'El valor minimo para el campo :attribute debes ser :min',
        'price.required' => 'El precio es un valor requerido',
        'stock.required' => 'La cantidad del producto es un valor requerido para actualizar',
        'description.required' => 'La descripcion es un valor requerido',
        'image.image' => 'La imagen debe ser de tipo jpg, png, jpeg'
        ];
    }
}

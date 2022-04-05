<?php

namespace App\Http\Requests\Admin\Products;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProductRequest extends FormRequest
{
    public function authorizate(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return[
            'name' => 'required|string|min:5|max:100',
            'price' => 'required|integer',
            'description' => 'required|string|min:10|max:255',
            'stock' => 'required|integer',
            'image' => 'image|max:1200|required',
            //'category_id' => ['required', 'numeric', 'exists:categories,id'],
        ];
    }

    public function messages(): array
      {
        return [
            'name.required' => 'El nombre es un valor requerido',
            'min' => 'El valor minimo para el campo :attribute debes ser :min',
            'price.required' => 'El precio es un valor requerido',
            'stock.required' => 'La cantidad del producto es un valor requerido',
            'description.required' => 'La descripcion es un valor requerido',
            'image.required' => 'Debe incluir una imagen para el producto',
            'image.image' => 'La imagen debe ser de tipo jpg, png, jpeg',
            //'category_id.required' => 'El producto debe tener una categoria', 
        ];
     }
}
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
        return[
            'name' => 'required|string|max:255',
            'price' => 'required|between:0,9999999',
            'description' => 'required|string|max:255',
            'stock' => 'required|between:0,9999999',
            'image' => 'image|max:1200|nullable',
        ];
    }
}
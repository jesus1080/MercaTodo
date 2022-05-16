<?php

namespace App\Http\Requests\Admin\Products;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCategoryRequest extends FormRequest
{
    public function authorizate(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return[
            'name' => 'required|string|min:5|max:100',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El nombre es un valor requerido',
        ];
    }
}

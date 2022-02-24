<?php

namespace App\Http\Requests\Admin\Products;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class IndexProductRequest extends FormRequest
{
    public function authorizate(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return[

            'filterName' => 'string',
        ];
    }

    public function messages(): array
      {
        return [
            'filterName.string' => 'Ve',
           
        ];
     }
}
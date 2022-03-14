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
        //dd('hola');
        return[

            'filterName' => 'bail|nullable|min:3|max:80',
            'filterPrice' => 'bail|nullable|min:3|max:80',
        ];
        
    }

    public function messages(): array
      {
        return [
            'filterName.min' => 'Ve! pone minimo 3 caracteres',
           
        ];
     }
}
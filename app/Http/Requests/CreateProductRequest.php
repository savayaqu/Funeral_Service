<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateProductRequest extends ApiRequest
{

    public function rules(): array
    {
        return [
            'name'        => 'required|min:1|max:64',
            'description' => 'required|nullable',
            'price'       => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'quantity'    => 'required|integer|min:1',
            'category_id' => 'required|integer|exists:categories,id',
            'path'      => '         file|mimes:jpg,webp,jpeg,png',
        ];
    }
}

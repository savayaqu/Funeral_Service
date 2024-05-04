<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends ApiRequest
{
    public function rules(): array
    {
        return [
            'name'        => 'min:1|max:64',
            'description' => 'nullable',
            'price'       => 'regex:/^\d+(\.\d{1,2})?$/',
            'quantity'    => 'integer|min:1',
            'category_id' => 'integer|min:1|exists:categories,id',
            'path'      => '         file|mimes:jpg,webp,jpeg,png',
        ];
    }
}

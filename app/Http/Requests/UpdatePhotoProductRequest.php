<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePhotoProductRequest extends ApiRequest
{

    public function rules(): array
    {
        return [
            'path.*' => 'file|mimes:jpg,webp,jpeg,png',
            'product_id' => 'integer|exists:products,id',
        ];
    }
}

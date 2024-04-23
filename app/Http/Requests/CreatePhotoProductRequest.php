<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreatePhotoProductRequest extends ApiRequest
{
    public function rules(): array
    {
        return [
            'path' => 'required|file|mimes:jpg,webp,jpeg,png',
            'product_id' => 'required|integer',
        ];
    }
}

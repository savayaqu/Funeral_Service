<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreatePhotoNewsRequest extends ApiRequest
{
    public function rules(): array
    {
        return [
            'path.*' => 'required|file|mimes:jpg,webp,jpeg,png',
            'news_id' => 'required|integer|exists:news,id',
        ];
    }
}

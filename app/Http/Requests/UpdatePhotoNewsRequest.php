<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePhotoNewsRequest extends ApiRequest
{

    public function rules(): array
    {
        return [
            'path.*' => 'file|mimes:jpg,webp,jpeg,png',
            'news_id' => 'integer|exists:news,id',
        ];
    }
}

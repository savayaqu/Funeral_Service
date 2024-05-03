<?php

namespace App\Http\Requests;

use App\Exceptions\ApiException;
use Illuminate\Foundation\Http\FormRequest;

class CreatePhotoProductPhoto extends ApiException
{
    public function rules(): array
    {
        return [
            'path.*' => 'required|file|mimes:jpg,webp,jpeg,png',
        ];
    }
}

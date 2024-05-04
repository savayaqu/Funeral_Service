<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateNewsRequest extends ApiRequest
{
    public function rules(): array
    {
        return [
            'date' => 'required|date_format:Y-m-d H:i:s',
            'name' => 'required|string|max:64',
            'short_description' => 'required|string|max:255',
            'long_description' => 'required|string',
            'path'      => 'file|mimes:jpg,webp,jpeg,png',
        ];
    }
}

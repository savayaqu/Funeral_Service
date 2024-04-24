<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateNewsRequest extends ApiRequest
{
    public function rules(): array
    {
        return [
            'date' =>               'date_format:Y-m-d H:i:s',
            'name' =>               'string|max:64',
            'short_description' =>  'string|max:255',
            'long_description' =>   'string',
        ];
    }
}

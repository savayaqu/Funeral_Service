<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BetweenDateOrderRequest extends ApiRequest
{
    public function rules(): array
    {
        return [
            'date_start' => 'required|date_format:Y-m-d',
            'date_end' => 'required|date_format:Y-m-d',
        ];
    }
}

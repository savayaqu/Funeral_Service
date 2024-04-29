<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DateOrderRequest extends ApiRequest
{
    public function rules(): array
    {
        return [
            'date_order' => 'required|date_format:Y-m-d',
        ];
    }
}

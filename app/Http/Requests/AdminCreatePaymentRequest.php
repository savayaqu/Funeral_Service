<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminCreatePaymentRequest extends ApiRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:64'
        ];
    }
}

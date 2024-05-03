<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateOrderRequest extends ApiRequest
{
    public function rules(): array
    {
        return [
            'payment_id' => 'required|integer|exists:payments,id'
        ];
    }
}

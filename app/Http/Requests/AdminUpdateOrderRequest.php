<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminUpdateOrderRequest extends ApiRequest
{
    public function rules(): array
    {
        return [
            'quantity' => 'integer|min:1',
            'product_id' => 'integer|exists:products,id',
        ];
    }
}

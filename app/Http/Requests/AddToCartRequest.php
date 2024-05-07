<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddToCartRequest extends ApiRequest
{
    public function rules(): array
    {
        return [
            'product_id' => 'integer|exists:products,id',
            'quantity' => 'integer',
        ];
    }
}

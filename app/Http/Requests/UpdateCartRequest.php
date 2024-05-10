<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCartRequest extends ApiRequest
{
    public function rules(): array
    {
        return [
            'product_id' => 'required|integer|min:1|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ];
    }
}

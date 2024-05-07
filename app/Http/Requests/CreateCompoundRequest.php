<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateCompoundRequest extends ApiRequest
{

    public function rules(): array
    {
        return [
            'quantity' => 'required|integer|min:1',
            'total_price' => 'nullable|regex:/^\d+(\.\d{1,2})?$/',
            'product_id' => 'required|integer|min:1|exists:products,id',
        ];
    }
}

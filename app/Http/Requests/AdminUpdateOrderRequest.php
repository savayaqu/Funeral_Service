<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminUpdateOrderRequest extends ApiRequest
{
    public function rules(): array
    {
        return [
            'quantity' => 'integer|min:1',
            'status_order_id' => 'integer|min:1',
            'product_id' => 'integer|min:1',
            'employee_id' => 'integer|min:1',
        ];
    }
}

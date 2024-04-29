<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'date_order' => 'date_format:Y-m-d H:i:s',
            'payment_id' => 'integer|min:1',
            'user_id' => 'integer|min:1',
            'employee_id' => 'integer|min:1|nullable',
            'status_order_id' => 'integer|min:1',
        ];
    }
}

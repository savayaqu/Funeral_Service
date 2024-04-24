<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddEmployeeOrderRequest extends ApiRequest
{
    public function rules(): array
    {
        return [
            'employee_id' => 'required|integer|min:1',
        ];
    }
}

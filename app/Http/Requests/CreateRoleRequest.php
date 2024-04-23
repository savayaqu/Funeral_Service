<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateRoleRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'name' => 'required|string|min:3',
            'code' => 'required|string|unique|min:3'
        ];
    }
}

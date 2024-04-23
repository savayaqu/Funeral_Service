<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRoleRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'name' => 'string|min:3',
            'code' => 'string|unique|min:3'
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRoleRequest extends ApiRequest
{

    public function rules(): array
    {
        return [
            'name' => 'string|min:3',
            'code' => 'string|min:3|unique:roles,code'
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateRoleRequest extends ApiRequest
{

    public function rules(): array
    {
        return [
            'name' => 'required|string|min:3|max:64',
            'code' => 'required|string|unique:roles,code|min:3|max:64'
        ];
    }
}

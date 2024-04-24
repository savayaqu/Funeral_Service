<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminCreateUserRequest extends ApiRequest
{
    public function rules(): array
    {
        return [
            'name'          => 'required|string|max:128',
            'surname'       => 'required|string|max:128',
            'patronymic'    =>          'nullable|string|max:128',
            'login'         => 'required|string|min:5|max:128|unique:users',
            'password'      => 'required|string|min:5|max:255|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/',
            'email'         => 'required|email|max:128|unique:users',
            'telephone'     => 'required|integer|digits_between:1,20|unique:users',
            'role_id'       => 'required|integer|min:1|exists:roles,id'
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminUpdateUserRequest extends ApiRequest
{

    public function rules(): array
    {
        return [
            'name'          => '        |string|max:128',
            'surname'       => '        |string|max:128',
            'patronymic'    =>          'nullable|string|max:128',
            'login'         => '        |string|min:5|max:128|unique:users',
            'password'      => '        |string|min:5|max:255|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/',
            'email'         => '        |email|max:128|unique:users',
            'telephone'     => '        |integer|digits_between:1,20|unique:users',
            'role_id'       => '        |integer|min:1|exists:roles,id'
        ];
    }
}

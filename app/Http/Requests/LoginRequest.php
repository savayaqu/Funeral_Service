<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends ApiRequest
{

    public function rules(): array
    {
        return [
            'login' => 'required|string|min:5|max:128',
            'password' => 'required|string|min:5|max:255'
        ];
    }
}

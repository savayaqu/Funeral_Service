<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends ApiRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
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
        ];
    }
}

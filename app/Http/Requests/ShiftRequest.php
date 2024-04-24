<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShiftRequest extends ApiRequest
{
    public function rules(): array
    {
        return [
            'user_id' => 'required|integer|min:1|exists:users,id'
        ];
    }
}

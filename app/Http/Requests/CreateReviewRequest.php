<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateReviewRequest extends ApiRequest
{
    public function rules(): array
    {
        return [
            'rating'      => 'required|integer|min:1|max:5',
            'description' => 'required|string|max:255'
        ];
    }
}

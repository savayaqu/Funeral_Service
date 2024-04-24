<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminCreateReviewRequest extends ApiRequest
{

    public function rules(): array
    {
        return [
            'rating'      => 'required|integer|min:1|max:5',
            'description' => 'required|string|max:255',
            'user_id'     => 'required|integer',
            'product_id'  => 'required|integer',
        ];
    }
}

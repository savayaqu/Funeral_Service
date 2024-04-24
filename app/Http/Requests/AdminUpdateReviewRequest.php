<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminUpdateReviewRequest extends ApiRequest
{

    public function rules(): array
    {
        return [
            'rating'      => 'integer|min:1|max:5',
            'description' => 'string|max:255',
            'user_id'     => 'integer',
            'product_id'  => 'integer',
        ];
    }
}

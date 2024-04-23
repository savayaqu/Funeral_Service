<?php

namespace App\Http\Requests;

use App\Exceptions\ApiException;
use Illuminate\Foundation\Http\FormRequest;

class CreateShiftRequest extends ApiRequest
{
    public function rules(): array
    {
        return [
            'status' => 'required|string|min:2|max:64',
            'date_start' => 'required|date_format:Y-m-d H:i:s',
            'date_end' => 'required|date_format:Y-m-d H:i:s',
        ];
    }
    protected function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $dateStart = $this->input('date_start');
            $dateEnd = $this->input('date_end');

            if ($dateStart >= $dateEnd) {
                throw new ApiException(400, 'Дата окончания должна быть позже даты начала');
            }
        });
    }
}

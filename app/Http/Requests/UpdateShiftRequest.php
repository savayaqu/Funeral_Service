<?php

namespace App\Http\Requests;

use App\Exceptions\ApiException;
use Illuminate\Foundation\Http\FormRequest;

class UpdateShiftRequest extends ApiRequest
{

    public function rules(): array
    {
        return [
            'status' =>     'integer|min:0|max:1',
            'date_start' => 'date_format:Y-m-d H:i:s',
            'date_end' =>   'date_format:Y-m-d H:i:s',
        ];
    }
    protected function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $dateStart = $this->input('date_start');
            $dateEnd = $this->input('date_end');

            if ($dateStart >= $dateEnd) {
                throw new ApiException(400, 'Некорректный запрос');
            }
        });
    }
}

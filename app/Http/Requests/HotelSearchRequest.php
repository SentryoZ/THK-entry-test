<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HotelSearchRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'hotel_name' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'hotel_name.required' => "何も入力されていません"
        ];
    }
}

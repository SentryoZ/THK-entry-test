<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HotelRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'hotel_name' => ['required'],
            'prefecture_id' => ['required', 'exists:prefectures,prefecture_id'],
            'hotel_image' => ['mimes:jpg,png']
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}

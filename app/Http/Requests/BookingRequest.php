<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookingRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'hotel_id' => ['required', 'exists:hotels'],
            'customer_name' => ['required'],
            'customer_contact' => ['required'],
            'checkin_time' => ['required', 'date'],
            'checkout_time' => ['required', 'date'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}

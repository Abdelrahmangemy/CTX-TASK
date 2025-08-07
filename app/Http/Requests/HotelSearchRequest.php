<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HotelSearchRequest extends FormRequest
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
            'location' => 'required|string',
            'check_in' => 'required|date|before:check_out',
            'check_out' => 'required|date|after:check_in',
            'guests' => 'sometimes|integer|min:1',
            'min_price' => 'sometimes|numeric|min:0',
            'max_price' => 'sometimes|numeric|gte:min_price',
            'sort_by' => 'sometimes|in:pricePerNight,rating',
        ];
}
}

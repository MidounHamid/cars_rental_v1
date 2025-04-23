<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatepromotionRequest extends FormRequest
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
            'discount_percent' => 'nullable|numeric|min:0|max:100',  // Ensure it's a valid percentage between 0 and 100
            'expires_at' => 'required|date|after_or_equal:starts_at',  // Ensure expires_at is a valid date and after starts_at
            'starts_at' => 'required|date|after_or_equal:today',  // Ensure starts_at is a valid date and today or in the future
        ];
    }
}

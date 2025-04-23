<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatereviewRequest extends FormRequest
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
            'user_id' => 'required|exists:users,id',  // Ensure the user exists in the 'users' table
            'car_id' => 'required|exists:cars,id',    // Ensure the car exists in the 'cars' table
            'rating' => 'nullable|integer|between:1,5',  // Ensure the rating is between 1 and 5 (optional)
            'comment' => 'nullable|string|max:500',  // Ensure the comment is a string with a maximum of 500 characters
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorebookingRequest extends FormRequest
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
            'user_id' => 'required|exists:users,id',
            'car_id' => 'required|exists:cars,id',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i',
            'status' => 'required|in:pending,confirmed,cancelled,completed',
            'promotion_id' => 'nullable|exists:promotions,id',
            'specifications' => 'nullable|array',
            'specifications.*.selected' => 'nullable',
            'specifications.*.quantity' => 'nullable|integer|min:1',
            'specifications.*.price' => 'nullable|numeric|min:0',
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Storecar_imageRequest extends FormRequest
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
            'car_id' => 'required|exists:cars,id', // Validate car_id is required and exists in the cars table
            'image_path' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048', // Validate the image file
            'is_primary' => 'nullable|boolean', // Validate the is_primary field
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class StoreBrandRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // tu peux le restreindre si nécessaire
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'brand' => 'required|string|max:255',
        ];
    }

    /**
     * Custom error messages (optional but recommended).
     */
    public function messages(): array
    {
        return [
            'brand.required' => 'required .',
        ];
    }
}



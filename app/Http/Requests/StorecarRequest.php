<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorecarRequest extends FormRequest
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
            'model' => 'required|string|max:255',
            'car_type_id' => 'nullable|exists:car_types,id',
            'city' => 'required|string|max:100',
            'price_per_day' => 'required|numeric|min:0',
            'fuel_types_id' => 'required|exists:fuel_types,id',
            'transmission' => 'nullable|in:Automatic,Manual,CVT,Semi-Automatic',
            'seats' => 'nullable|integer|min:1|max:12',
            'is_available' => 'nullable|boolean',
            'agency_id' => 'nullable|exists:agencies,id',
            'brand_id' => 'required|exists:brands,id',
            'insurance_id' => 'required|exists:insurances,id',
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Storecar_speficationRequest extends FormRequest
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
            'car_id' => 'required|exists:cars,id', // Validate that car_id exists in the cars table
            'specification_id' => 'required|exists:specifications,id', // Validate that specification_id exists in the specifications table
        ];
    }
}

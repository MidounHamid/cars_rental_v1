<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Updatemode_paymentRequest extends FormRequest
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
            'mode_payment' => 'required|string|max:100|unique:mode_payments,mode_payment',
        ];
    }
}

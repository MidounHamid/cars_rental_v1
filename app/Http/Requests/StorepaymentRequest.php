<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorepaymentRequest extends FormRequest
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
            'booking_id' => 'required|exists:bookings,id',  // Ensures booking exists
            'amount' => 'required|numeric|min:0.01',  // Ensures a positive numeric value for the amount
            'status' => 'required|in:pending,successful,failed,refunded',  // Validates the payment status
            'mode_payment_id' => 'required|exists:mode_payments,id',  // Ensures the mode_payment_id exists in the mode_payments table
            'transaction_id' => 'nullable|string|unique:payments,transaction_id'  // Optional transaction ID
        ];
    }
}

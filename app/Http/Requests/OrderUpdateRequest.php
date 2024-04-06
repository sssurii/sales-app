<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderUpdateRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'customer_id' => ['required', 'integer'],
            'table_id' => ['required', 'integer'],
            'status' => ['required', 'string', 'max:255'],
            'created_at' => ['required'],
            'updated_at' => ['required'],
            'placed_by' => ['required', 'string', 'max:255'],
            'served_by' => ['required', 'string', 'max:255'],
            'customer_notes' => ['required', 'string'],
            'internal_notes' => ['required', 'string'],
            'sub_total' => ['required', 'numeric', 'between:-999999.99,999999.99'],
            'tax' => ['required', 'numeric', 'between:-999999.99,999999.99'],
            'discount' => ['required', 'numeric', 'between:-999999.99,999999.99'],
            'discount_type' => ['required', 'string', 'max:255'],
            'total_price' => ['required', 'numeric', 'between:-999999.99,999999.99'],
            'payment_method' => ['required', 'string', 'max:255'],
            'payment_reference' => ['required', 'string', 'max:255'],
            'payment_received' => ['required'],
            'user_id' => ['required', 'integer', 'exists:users,id'],
        ];
    }
}

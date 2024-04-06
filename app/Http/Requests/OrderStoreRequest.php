<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderStoreRequest extends FormRequest
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
            'sub_total' => ['required', 'numeric', 'between:-999999.99,999999.99'],
            'tax' => ['required', 'numeric', 'between:-999999.99,999999.99'],
            'total_price' => ['required', 'numeric', 'between:-999999.99,999999.99'],
            'payment_method' => ['required', 'string', 'max:255'],
        ];
    }
}

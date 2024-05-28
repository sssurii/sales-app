<?php

namespace App\Http\Requests;

use App\Enums\OrderStatusEnum;
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

    public function prepareForValidation()
    {
        $this->merge([
            'status' => OrderStatusEnum::PLACED,
            'payment_method' => 'cash',
            'placed_by' => $this->user?->id ?? 1,
            'served_by' => $this->user?->id ?? 1,
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'user_id' => ['nullable', 'integer'],
            'table_id' => ['nullable', 'integer'],
            'status' => ['required', 'string', 'max:255'],
            'sub_total' => ['required', 'numeric', 'between:-999999.99,999999.99'],
            'tax' => ['required', 'numeric', 'between:-999999.99,999999.99'],
            'total_price' => ['required', 'numeric', 'between:-999999.99,999999.99'],
            'payment_method' => ['required', 'string', 'max:255'],
            'items' => ['required', 'array'],
            'items.*.id' => ['required', 'integer', 'exists:food_items,id'],
            'items.*.quantity' => ['required', 'integer', 'min:1'],
            'items.*.price' => ['required', 'numeric', 'between:-999999.99,999999.99'],
            'items.*.discount' => ['nullable', 'numeric', 'between:-999999.99,999999.99'],
            'items.*.discount_type' => ['nullable', 'string', 'max:255'],
            'customer_notes' => ['nullable', 'string'],
            'placed_by' => ['nullable', 'integer'],
            'served_by' => ['nullable', 'integer'],
        ];
    }
}

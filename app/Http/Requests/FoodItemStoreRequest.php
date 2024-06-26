<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FoodItemStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'availability' => $this->availability === 'true',
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'between:-999999.99,999999.99'],
            'category' => ['nullable', 'string', 'max:255'],
            'availability' => ['required', 'boolean'],
            'image' => ['nullable', 'image', 'max:1024'],
        ];
    }
}

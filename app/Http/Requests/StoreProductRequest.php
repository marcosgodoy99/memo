<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'code' => 'required|string|digits_between:1,13|unique:products,code',
            'name' => 'required|string|max:250',
            'stock' => 'required|integer|min:0|max:10000',
            'price' => 'required',
            'description' => 'nullable|string|max:500',
            'links' => 'nullable|string',
        ];
    }
}
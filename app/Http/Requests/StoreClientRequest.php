<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClientRequest extends FormRequest
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
            'username' => 'required|string|unique:clients,username',
            'address' => 'nullable|string',
            'cuit' => 'nullable|integer|digits_between:8,11',
            'phone' => 'nullable|string|digits_between:10,13',
            'users_id'=> 'required|integer'
        ];
    }
}

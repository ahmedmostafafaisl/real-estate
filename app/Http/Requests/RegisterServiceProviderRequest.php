<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterServiceProviderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'phone' => ['required', 'string', 'unique:users,phone'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'office_name' => ['required', 'string', 'max:255'],
            'provider_type' => ['required', 'in:agency,broker,owner,developer'],
            'city_id' => ['required', 'exists:cities,id'],
            'commercial_register_no' => ['nullable', 'string'],
            'license_no' => ['nullable', 'string'],
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePropertyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->user_type === 'service_provider';
    }

    public function rules(): array
    {
        return [
            'property_category_id' => ['required', 'exists:property_categories,id'],
            'property_type_id' => ['required', 'exists:property_types,id'],
            'city_id' => ['required', 'exists:cities,id'],
            'district_id' => ['nullable', 'exists:districts,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'listing_type' => ['required', 'in:sale,rent'],
            'price' => ['required', 'numeric', 'min:0'],
            'area_sqm' => ['nullable', 'numeric', 'min:0'],
            'bedrooms' => ['nullable', 'integer', 'min:0'],
            'bathrooms' => ['nullable', 'integer', 'min:0'],
            'dynamic_attributes' => ['nullable', 'array'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'features' => ['nullable', 'array'],
            'features.*' => ['exists:property_features,id'],
        ];
    }
}

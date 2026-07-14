<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePropertyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->route('property')->service_provider_id === $this->user()->serviceProvider?->id;
    }

    public function rules(): array
    {
        return [
            'title' => ['sometimes', 'string', 'max:255'],
            'description' => ['sometimes', 'nullable', 'string'],
            'price' => ['sometimes', 'numeric', 'min:0'],
            'area_sqm' => ['sometimes', 'nullable', 'numeric', 'min:0'],
            'bedrooms' => ['sometimes', 'nullable', 'integer', 'min:0'],
            'bathrooms' => ['sometimes', 'nullable', 'integer', 'min:0'],
            'dynamic_attributes' => ['sometimes', 'array'],
            'district_id' => ['sometimes', 'nullable', 'exists:districts,id'],
            'features' => ['sometimes', 'array'],
            'features.*' => ['exists:property_features,id'],
            'photos' => ['sometimes', 'array', 'max:10'],
            'photos.*' => ['image', 'max:5120'],
            'delete_images' => ['sometimes', 'array'],
            'delete_images.*' => ['integer', 'exists:property_images,id'],
            'featured_image_id' => ['sometimes', 'integer', 'exists:property_images,id'],
        ];
    }
}

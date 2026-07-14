<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PropertyResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'description' => $this->description,
            'listing_type' => $this->listing_type,
            'price' => (float) $this->price,
            'area_sqm' => $this->area_sqm,
            'bedrooms' => $this->bedrooms,
            'bathrooms' => $this->bathrooms,
            'status' => $this->status,
            'is_featured' => $this->is_featured,
            'views_count' => $this->views_count,
            'is_favorited' => $request->user()
                ? $request->user()->favorites()->where('property_id', $this->id)->exists()
                : false,
            'location' => [
                'city' => $this->whenLoaded('city', fn () => $this->city->name),
                'district' => $this->whenLoaded('district', fn () => $this->district?->name),
                'latitude' => $this->latitude,
                'longitude' => $this->longitude,
            ],
            'category' => $this->whenLoaded('category', fn () => $this->category->name),
            'type' => $this->whenLoaded('type', fn () => $this->type->name),
            'provider' => $this->whenLoaded('serviceProvider', fn () => [
                'id' => $this->serviceProvider->id,
                'office_name' => $this->serviceProvider->office_name,
                'verification_status' => $this->serviceProvider->verification_status,
            ]),
            'images' => PropertyImageResource::collection($this->whenLoaded('images')),
            'features' => $this->whenLoaded('features', fn () => $this->features->pluck('name')),
            'published_at' => $this->published_at,
            'created_at' => $this->created_at,
        ];
    }
}

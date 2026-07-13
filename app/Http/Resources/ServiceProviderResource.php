<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceProviderResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'office_name' => $this->office_name,
            'provider_type' => $this->provider_type,
            'verification_status' => $this->verification_status,
            'commission_rate' => (float) $this->commission_rate,
            'city' => $this->whenLoaded('city', fn () => $this->city->name),
            'properties_count' => $this->whenCounted('properties'),
            'active_subscription' => $this->whenLoaded('activeSubscription', fn () => $this->activeSubscription ? [
                'plan' => $this->activeSubscription->package->name,
                'ends_at' => $this->activeSubscription->ends_at,
            ] : null),
            'created_at' => $this->created_at,
        ];
    }
}

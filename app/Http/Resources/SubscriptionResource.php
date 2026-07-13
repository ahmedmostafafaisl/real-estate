<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SubscriptionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'provider' => $this->whenLoaded('serviceProvider', fn () => $this->serviceProvider->office_name),
            'plan' => $this->whenLoaded('package', fn () => $this->package->name),
            'status' => $this->status,
            'starts_at' => $this->starts_at,
            'ends_at' => $this->ends_at,
            'auto_renew' => $this->auto_renew,
        ];
    }
}

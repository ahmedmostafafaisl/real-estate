<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PropertyImageResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'url' => asset('storage/' . $this->path),
            'type' => $this->type,
            'is_featured' => $this->is_featured,
            'sort_order' => $this->sort_order,
        ];
    }
}

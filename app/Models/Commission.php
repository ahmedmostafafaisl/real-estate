<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commission extends Model
{
    use HasFactory;

    protected $fillable = [
        'property_id', 'service_provider_id', 'deal_type', 'deal_value',
        'commission_rate', 'commission_amount', 'status', 'paid_at',
    ];

    protected function casts(): array
    {
        return ['paid_at' => 'datetime'];
    }

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function serviceProvider()
    {
        return $this->belongsTo(ServiceProvider::class);
    }

    public static function generateFor(Property $property): self
    {
        $rate = $property->serviceProvider->commission_rate;

        return self::create([
            'property_id' => $property->id,
            'service_provider_id' => $property->service_provider_id,
            'deal_type' => $property->status, // 'sold' or 'rented'
            'deal_value' => $property->price,
            'commission_rate' => $rate,
            'commission_amount' => round($property->price * $rate / 100, 2),
        ]);
    }
}

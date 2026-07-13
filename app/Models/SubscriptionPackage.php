<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubscriptionPackage extends Model
{
    protected $fillable = [
        'name', 'slug', 'price', 'billing_cycle', 'listing_limit',
        'featured_listing_limit', 'perks', 'is_active',
    ];

    protected function casts(): array
    {
        return ['perks' => 'array', 'is_active' => 'boolean'];
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceProvider extends Model
{
    protected $fillable = [
        'user_id', 'office_name', 'provider_type', 'commercial_register_no',
        'license_no', 'city_id', 'address', 'logo', 'bio',
        'verification_status', 'verified_at', 'commission_rate',
    ];

    protected function casts(): array
    {
        return ['verified_at' => 'datetime', 'commission_rate' => 'decimal:2'];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function documents()
    {
        return $this->hasMany(ProviderDocument::class);
    }

    public function employees()
    {
        return $this->hasMany(ProviderEmployee::class);
    }

    public function properties()
    {
        return $this->hasMany(Property::class);
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function activeSubscription()
    {
        return $this->hasOne(Subscription::class)->where('status', 'active')->latestOfMany();
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function commissions()
    {
        return $this->hasMany(Commission::class);
    }
}

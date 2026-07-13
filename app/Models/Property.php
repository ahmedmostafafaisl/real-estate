<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Property extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'service_provider_id', 'property_category_id', 'property_type_id',
        'city_id', 'district_id', 'title', 'slug', 'description',
        'listing_type', 'price', 'area_sqm', 'bedrooms', 'bathrooms',
        'dynamic_attributes', 'latitude', 'longitude', 'status',
        'rejection_reason', 'is_featured', 'published_at', 'expires_at',
    ];

    protected function casts(): array
    {
        return [
            'dynamic_attributes' => 'array',
            'is_featured' => 'boolean',
            'published_at' => 'datetime',
            'expires_at' => 'datetime',
            'price' => 'decimal:2',
        ];
    }

    // Lifecycle: draft -> pending -> published -> sold|rented|expired (or rejected)
    public function serviceProvider()
    {
        return $this->belongsTo(ServiceProvider::class);
    }

    public function category()
    {
        return $this->belongsTo(PropertyCategory::class, 'property_category_id');
    }

    public function type()
    {
        return $this->belongsTo(PropertyType::class, 'property_type_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function images()
    {
        return $this->hasMany(PropertyImage::class)->orderBy('sort_order');
    }

    public function features()
    {
        return $this->belongsToMany(PropertyFeature::class, 'property_feature_property');
    }

    public function inquiries()
    {
        return $this->hasMany(Inquiry::class);
    }

    public function viewingRequests()
    {
        return $this->hasMany(ViewingRequest::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function reports()
    {
        return $this->hasMany(PropertyReport::class);
    }

    public function commission()
    {
        return $this->hasOne(Commission::class);
    }

    public function submitForReview(): void
    {
        $this->update(['status' => 'pending']);
    }

    public function approve(): void
    {
        $this->update(['status' => 'published', 'published_at' => now()]);
    }

    public function reject(string $reason): void
    {
        $this->update(['status' => 'rejected', 'rejection_reason' => $reason]);
    }
}

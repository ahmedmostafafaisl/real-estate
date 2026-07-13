<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ViewingRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'property_id', 'user_id', 'service_provider_id',
        'requested_slot', 'status', 'notes',
    ];

    protected function casts(): array
    {
        return ['requested_slot' => 'datetime'];
    }

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function serviceProvider()
    {
        return $this->belongsTo(ServiceProvider::class);
    }
}

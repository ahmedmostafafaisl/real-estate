<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    protected $fillable = ['region_id', 'name', 'latitude', 'longitude', 'is_active'];

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function districts()
    {
        return $this->hasMany(District::class);
    }

    public function properties()
    {
        return $this->hasMany(Property::class);
    }
}

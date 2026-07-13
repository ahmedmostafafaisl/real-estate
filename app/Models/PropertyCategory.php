<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PropertyCategory extends Model
{
    protected $fillable = ['name', 'slug', 'icon', 'is_active'];

    public function types()
    {
        return $this->hasMany(PropertyType::class);
    }

    public function properties()
    {
        return $this->hasMany(Property::class);
    }
}

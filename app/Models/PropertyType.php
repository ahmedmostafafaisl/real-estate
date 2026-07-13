<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PropertyType extends Model
{
    protected $fillable = ['property_category_id', 'name', 'slug', 'dynamic_fields', 'is_active'];

    protected function casts(): array
    {
        return ['dynamic_fields' => 'array'];
    }

    public function category()
    {
        return $this->belongsTo(PropertyCategory::class, 'property_category_id');
    }

    public function properties()
    {
        return $this->hasMany(Property::class);
    }
}

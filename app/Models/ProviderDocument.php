<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProviderDocument extends Model
{
    protected $fillable = ['service_provider_id', 'type', 'file_path', 'status'];

    public function serviceProvider()
    {
        return $this->belongsTo(ServiceProvider::class);
    }
}

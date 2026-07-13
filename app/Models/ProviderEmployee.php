<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProviderEmployee extends Model
{
    protected $fillable = ['service_provider_id', 'name', 'email', 'phone', 'job_title', 'is_active'];

    public function serviceProvider()
    {
        return $this->belongsTo(ServiceProvider::class);
    }
}

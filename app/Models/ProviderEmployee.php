<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProviderEmployee extends Model
{
    use HasFactory;

    protected $fillable = ['service_provider_id', 'name', 'email', 'phone', 'job_title', 'is_active'];

    public function serviceProvider()
    {
        return $this->belongsTo(ServiceProvider::class);
    }
}

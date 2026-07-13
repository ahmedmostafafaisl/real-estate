<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, HasRoles;

    protected $fillable = [
        'name', 'email', 'phone', 'password', 'user_type', 'avatar', 'is_active',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'is_active' => 'boolean',
            'password' => 'hashed',
        ];
    }

    public function serviceProvider()
    {
        return $this->hasOne(ServiceProvider::class);
    }

    public function favorites()
    {
        return $this->belongsToMany(Property::class, 'favorites')->withTimestamps();
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
}

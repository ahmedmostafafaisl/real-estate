<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'invoice_number', 'service_provider_id', 'subscription_id',
        'subtotal', 'tax_rate', 'tax_amount', 'total', 'status', 'due_at',
    ];

    protected function casts(): array
    {
        return ['due_at' => 'datetime'];
    }

    public function serviceProvider()
    {
        return $this->belongsTo(ServiceProvider::class);
    }

    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}

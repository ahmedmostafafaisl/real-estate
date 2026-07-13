<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_id', 'transaction_ref', 'method', 'amount',
        'status', 'gateway_response', 'paid_at',
    ];

    protected function casts(): array
    {
        return ['gateway_response' => 'array', 'paid_at' => 'datetime'];
    }

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}

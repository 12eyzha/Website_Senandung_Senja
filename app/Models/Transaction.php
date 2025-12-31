<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'transaction_code',
        'total_amount',
        'payment_method',
        'payment_status',
        'user_id',
        'status',
        'cancel_reason',
        'cancelled_at',
    ];

    protected $casts = [
        'cancelled_at' => 'datetime',
    ];

    public function items()
    {
        return $this->hasMany(TransactionItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

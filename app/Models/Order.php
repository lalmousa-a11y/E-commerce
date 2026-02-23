<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Order extends Model
{
    protected $fillable = [
        'user_id',
        'total_amount',
        'status',
        'payment_status',
        'transaction_id',
        'discount_amount',
        'discount_name',
        'final_amount',
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
       public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

}
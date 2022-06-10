<?php

namespace App\Models;

use App\Enums\returnOrderStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ReturnOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'status',
    ];

    protected $casts = [
        'status' => returnOrderStatusEnum::class . ':nullable',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(
            Order::class,
            'order_id',
            'id'
        );
    }

    public function items(): HasMany
    {
        return $this->hasMany(
            ReturnOrderItem::class,
            'return_order_id',
            'id'
        );
    }
}

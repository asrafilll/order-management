<?php

namespace App\Models;

use App\Enums\returnOrderStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\ReturnOrder
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $order_id
 * @property \Spatie\Enum\Enum|null|null $status
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ReturnOrderItem[] $items
 * @property-read int|null $items_count
 * @property-read \App\Models\Order $order
 * @method static \Illuminate\Database\Eloquent\Builder|ReturnOrder newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ReturnOrder newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ReturnOrder query()
 * @method static \Illuminate\Database\Eloquent\Builder|ReturnOrder whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReturnOrder whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReturnOrder whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReturnOrder whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReturnOrder whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\ReturnOrderItem
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $order_id
 * @property int $order_item_id
 * @property int $quantity
 * @property string|null $reason
 * @property \Illuminate\Support\Carbon|null $published_at
 * @method static \Database\Factories\ReturnOrderItemFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|ReturnOrderItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ReturnOrderItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ReturnOrderItem query()
 * @method static \Illuminate\Database\Eloquent\Builder|ReturnOrderItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReturnOrderItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReturnOrderItem whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReturnOrderItem whereOrderItemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReturnOrderItem wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReturnOrderItem whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReturnOrderItem whereReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReturnOrderItem whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ReturnOrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'order_item_id',
        'quantity',
        'reason',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(
            Order::class,
            'order_id',
            'id'
        );
    }

    public function orderItem(): BelongsTo
    {
        return $this->belongsTo(
            OrderItem::class,
            'order_item_id',
            'id'
        );
    }

    public function isPublished(): bool
    {
        return !is_null($this->published_at);
    }
}

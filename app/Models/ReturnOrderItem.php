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
 * @property int $return_order_id
 * @property int $order_item_id
 * @property int $quantity
 * @property string|null $reason
 * @property-read \App\Models\OrderItem $orderItem
 * @property-read \App\Models\ReturnOrder $returnOrder
 * @method static \Database\Factories\ReturnOrderItemFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|ReturnOrderItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ReturnOrderItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ReturnOrderItem query()
 * @method static \Illuminate\Database\Eloquent\Builder|ReturnOrderItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReturnOrderItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReturnOrderItem whereOrderItemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReturnOrderItem whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReturnOrderItem whereReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReturnOrderItem whereReturnOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReturnOrderItem whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ReturnOrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'return_order_id',
        'order_item_id',
        'quantity',
        'reason',
    ];

    public function returnOrder(): BelongsTo
    {
        return $this->belongsTo(
            ReturnOrder::class,
            'return_order_id',
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

    protected static function booted()
    {
        static::created(function (ReturnOrderItem $returnOrderItem) {
            $returnOrderItem->orderItem->update([
                'returned_quantity' => $returnOrderItem->getReturnedQuantity() + $returnOrderItem->quantity,
            ]);
        });

        static::updated(function (ReturnOrderItem $returnOrderItem) {
            $returnOrderItem->orderItem->update([
                'returned_quantity' => $returnOrderItem->getReturnedQuantity() + $returnOrderItem->quantity,
            ]);
        });

        static::deleted(function (ReturnOrderItem $returnOrderItem) {
            $returnOrderItem->orderItem->update([
                'returned_quantity' => $returnOrderItem->getReturnedQuantity() ?: null,
            ]);
        });
    }

    public function getReturnedQuantity(): int
    {
        return ReturnOrderItem::query()
            ->where('id', '!=', $this->id)
            ->whereOrderItemId($this->order_item_id)
            ->sum('quantity');
    }
}

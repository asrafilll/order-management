<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\OrderItem
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $order_id
 * @property int $product_id
 * @property string $product_slug
 * @property string $product_name
 * @property string|null $product_description
 * @property int $variant_id
 * @property string $variant_name
 * @property int $variant_price
 * @property int $variant_weight
 * @property string $variant_option1
 * @property string $variant_value1
 * @property string|null $variant_option2
 * @property string|null $variant_value2
 * @property int $quantity
 * @property-read \App\Models\Order $order
 * @method static \Database\Factories\OrderItemFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem query()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereProductDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereProductName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereProductSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereVariantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereVariantName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereVariantOption1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereVariantOption2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereVariantPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereVariantValue1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereVariantValue2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereVariantWeight($value)
 * @mixin \Eloquent
 */
class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'product_slug',
        'product_name',
        'product_description',
        'variant_id',
        'variant_name',
        'variant_price',
        'variant_weight',
        'variant_option1',
        'variant_value1',
        'variant_option2',
        'variant_value2',
        'quantity',
    ];

    protected $attributes = [
        'quantity' => 1,
    ];

    protected static function booted()
    {
        static::created(function (OrderItem $orderItem) {
            $orderItem->order->calculateItemsSummary();
        });

        static::updated(function (OrderItem $orderItem) {
            $orderItem->order->calculateItemsSummary();
        });

        static::deleted(function (OrderItem $orderItem) {
            $orderItem->order->calculateItemsSummary();
        });
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}

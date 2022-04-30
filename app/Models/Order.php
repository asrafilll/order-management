<?php

namespace App\Models;

use App\Enums\OrderStatusEnum;
use App\Enums\PaymentStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Order
 *
 * @property \Spatie\Enum\Enum|null $status
 * @property \Spatie\Enum\Enum|null $payment_status
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\OrderItem[] $items
 * @property-read int|null $items_count
 * @method static \Database\Factories\OrderFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Order newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Order newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Order query()
 * @mixin \Eloquent
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $source_id
 * @property string $source_name
 * @property int $customer_id
 * @property string $customer_name
 * @property string $customer_phone
 * @property string $customer_address
 * @property string $customer_province
 * @property string $customer_city
 * @property string $customer_subdistrict
 * @property string $customer_village
 * @property string $customer_postal_code
 * @property int|null $payment_method_id
 * @property string|null $payment_method_name
 * @property int|null $shipping_id
 * @property string|null $shipping_name
 * @property string|null $shipping_date
 * @property string|null $shipping_airwaybill
 * @property int|null $items_quantity
 * @property int|null $items_price
 * @property int|null $items_discount
 * @property int|null $shipping_price
 * @property int|null $shipping_discount
 * @property int|null $total_price
 * @property string|null $note
 * @property string|null $returned_at
 * @property string|null $returned_note
 * @property int|null $sales_id
 * @property string|null $sales_name
 * @property int|null $creator_id
 * @property string|null $creator_name
 * @property int|null $packer_id
 * @property string|null $packer_name
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCreatorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCreatorName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCustomerAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCustomerCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCustomerName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCustomerPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCustomerPostalCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCustomerProvince($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCustomerSubdistrict($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCustomerVillage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereItemsDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereItemsPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereItemsQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order wherePackerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order wherePackerName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order wherePaymentMethodId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order wherePaymentMethodName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order wherePaymentStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereReturnedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereReturnedNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereSalesId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereSalesName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereShippingAirwaybill($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereShippingDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereShippingDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereShippingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereShippingName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereShippingPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereSourceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereSourceName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereTotalPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereUpdatedAt($value)
 */
class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'status',
        'source_id',
        'source_name',
        'customer_id',
        'customer_name',
        'customer_phone',
        'customer_address',
        'customer_province',
        'customer_city',
        'customer_subdistrict',
        'customer_village',
        'customer_postal_code',
        'payment_method_id',
        'payment_method_name',
        'payment_status',
        'shipping_id',
        'shipping_name',
        'shipping_date',
        'shipping_airwaybill',
        'items_quantity',
        'items_price',
        'items_discount',
        'shipping_price',
        'shipping_discount',
        'total_price',
        'note',
        'returned_at',
        'returned_note',
        'sales_id',
        'sales_name',
        'creator_id',
        'creator_name',
        'packer_id',
        'packer_name',
    ];

    protected $casts = [
        'status' => OrderStatusEnum::class,
        'payment_status' => PaymentStatusEnum::class,
    ];

    protected static function booted()
    {
        static::updated(function (Order $order) {
            $order->calculateSummary();
        });
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function isEditable(): bool
    {
        return $this->status->equals(OrderStatusEnum::waiting());
    }

    public function calculateSummary(): void
    {
        $this->load(['items']);

        $this->items_quantity = intval($this->items()->sum('quantity'));
        $this->items_price = $this
            ->items
            ->reduce(
                fn (int $acc, OrderItem $orderItem) => $acc + ($orderItem->variant_price * $orderItem->quantity),
                0
            );
        $this->total_price = ($this->items_price - intval($this->items_discount)) +
            (intval($this->shipping_price) - intval($this->shipping_discount));
        $this->saveQuietly();
    }
}

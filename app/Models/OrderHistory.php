<?php

namespace App\Models;

use App\Enums\OrderHistoryTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\OrderHistory
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Spatie\Enum\Enum|null $type
 * @property int $order_id
 * @property string $from
 * @property string $to
 * @property-read \App\Models\Order $order
 * @method static \Database\Factories\OrderHistoryFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderHistory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderHistory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderHistory query()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderHistory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderHistory whereFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderHistory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderHistory whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderHistory whereTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderHistory whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderHistory whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class OrderHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'type',
        'from',
        'to',
    ];

    protected $casts = [
        'type' => OrderHistoryTypeEnum::class,
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}

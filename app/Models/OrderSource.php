<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\OrderSource
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $name
 * @property int|null $parent_id
 * @method static \Database\Factories\OrderSourceFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderSource newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderSource newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderSource query()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderSource whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderSource whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderSource whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderSource whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderSource whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|OrderSource[] $child
 * @property-read int|null $child_count
 * @property-read OrderSource|null $parent
 */
class OrderSource extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'parent_id',
    ];

    protected static function booted()
    {
        static::deleting(function (OrderSource $orderSource) {
            OrderSource::whereParentId($orderSource->id)
                ->update([
                    'parent_id' => null,
                ]);
        });
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(
            OrderSource::class,
            'parent_id',
            'id',
        );
    }

    public function child(): HasMany
    {
        return $this->hasMany(
            OrderSource::class,
            'parent_id',
            'id',
        );
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\ProductVariant
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $product_id
 * @property int $price
 * @property int|null $weight
 * @property int|null $width
 * @property int|null $height
 * @property int|null $length
 * @property string|null $option1
 * @property string|null $value1
 * @property string|null $option2
 * @property string|null $value2
 * @property string|null $option3
 * @property string|null $value3
 * @property-read \App\Models\Product $product
 * @method static \Database\Factories\ProductVariantFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductVariant newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductVariant newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductVariant query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductVariant whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductVariant whereHeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductVariant whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductVariant whereLength($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductVariant whereOption1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductVariant whereOption2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductVariant whereOption3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductVariant wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductVariant whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductVariant whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductVariant whereValue1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductVariant whereValue2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductVariant whereValue3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductVariant whereWeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductVariant whereWidth($value)
 * @mixin \Eloquent
 */
class ProductVariant extends Model
{
    use HasFactory;

    protected $fillable = [
        'price',
        'weight',
        'width',
        'height',
        'length',
        'option1',
        'value1',
        'option2',
        'value2',
        'option3',
        'value3',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(
            related: Product::class,
            foreignKey: 'product_id',
            ownerKey: 'id'
        );
    }
}

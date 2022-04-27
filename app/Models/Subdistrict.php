<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Subdistrict
 *
 * @property string $code
 * @property string $parent
 * @property string $name
 * @property-read \App\Models\City|null $city
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Village[] $villages
 * @property-read int|null $villages_count
 * @method static \Illuminate\Database\Eloquent\Builder|Subdistrict newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Subdistrict newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Subdistrict query()
 * @method static \Illuminate\Database\Eloquent\Builder|Subdistrict whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subdistrict whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subdistrict whereParent($value)
 * @mixin \Eloquent
 */
class Subdistrict extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'parent',
        'name',
    ];

    public $timestamps = false;

    public function city(): BelongsTo
    {
        return $this->belongsTo(
            City::class,
            'parent',
            'code'
        );
    }

    public function villages(): HasMany
    {
        return $this->hasMany(
            Village::class,
            'parent',
            'code'
        );
    }
}

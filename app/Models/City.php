<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\City
 *
 * @property string $code
 * @property string $parent
 * @property string $name
 * @property-read \App\Models\Province|null $province
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Subdistrict[] $subdistricts
 * @property-read int|null $subdistricts_count
 * @method static \Illuminate\Database\Eloquent\Builder|City newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|City newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|City query()
 * @method static \Illuminate\Database\Eloquent\Builder|City whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereParent($value)
 * @mixin \Eloquent
 */
class City extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'parent',
        'name',
    ];

    public $timestamps = false;

    public function province(): BelongsTo
    {
        return $this->belongsTo(
            Province::class,
            'parent',
            'code'
        );
    }

    public function subdistricts(): HasMany
    {
        return $this->hasMany(
            Subdistrict::class,
            'parent',
            'code'
        );
    }
}

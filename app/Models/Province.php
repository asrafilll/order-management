<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Province
 *
 * @property string $code
 * @property string $name
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\City[] $cities
 * @property-read int|null $cities_count
 * @method static \Illuminate\Database\Eloquent\Builder|Province newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Province newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Province query()
 * @method static \Illuminate\Database\Eloquent\Builder|Province whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Province whereName($value)
 * @mixin \Eloquent
 */
class Province extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
    ];

    public $timestamps = false;

    public function cities(): HasMany
    {
        return $this->hasMany(
            City::class,
            'parent',
            'code'
        );
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Village
 *
 * @property string $code
 * @property string $parent
 * @property string $name
 * @property-read \App\Models\Subdistrict|null $subdistrict
 * @method static \Illuminate\Database\Eloquent\Builder|Village newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Village newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Village query()
 * @method static \Illuminate\Database\Eloquent\Builder|Village whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Village whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Village whereParent($value)
 * @mixin \Eloquent
 */
class Village extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'parent',
        'name',
    ];

    public $timestamps = false;

    public function subdistrict(): BelongsTo
    {
        return $this->belongsTo(
            Subdistrict::class,
            'parent',
            'code'
        );
    }
}

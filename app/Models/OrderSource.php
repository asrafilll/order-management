<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\OrderSource
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $name
 * @method static \Database\Factories\OrderSourceFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderSource newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderSource newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderSource query()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderSource whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderSource whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderSource whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderSource whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class OrderSource extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];
}

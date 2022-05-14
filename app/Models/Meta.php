<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Meta
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $key
 * @property string $value
 * @method static \Database\Factories\MetaFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Meta newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Meta newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Meta query()
 * @method static \Illuminate\Database\Eloquent\Builder|Meta whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Meta whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Meta whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Meta whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Meta whereValue($value)
 * @mixin \Eloquent
 */
class Meta extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
    ];

    /**
     * @param string $key
     * @return string|null
     */
    public static function findByKey(string $key)
    {
        return Meta::where('key', $key)->value('value');
    }

    public static function createOrUpdate(string $key, string $value): Meta
    {
        return Meta::updateOrCreate([
            'key' => $key,
        ], [
            'value' => $value,
        ]);
    }
}

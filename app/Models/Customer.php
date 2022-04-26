<?php

namespace App\Models;

use App\Enums\CustomerTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Customer
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $name
 * @property string $phone
 * @property string $address
 * @property string $province_code
 * @property string $province_name
 * @property string $city_code
 * @property string $city_name
 * @property string $subdistrict_code
 * @property string $subdistrict_name
 * @property string $village_code
 * @property string $village_name
 * @property string $postal_code
 * @property string $type
 * @method static \Database\Factories\CustomerFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Customer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Customer query()
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereCityCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereCityName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer wherePostalCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereProvinceCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereProvinceName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereSubdistrictCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereSubdistrictName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereVillageCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereVillageName($value)
 * @mixin \Eloquent
 */
class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'province_code',
        'province_name',
        'city_code',
        'city_name',
        'subdistrict_code',
        'subdistrict_name',
        'village_code',
        'village_name',
        'postal_code',
        'type',
    ];

    protected static function booted()
    {
        static::creating(function (Customer $customer) {
            $customer->type = $customer->type ?? CustomerTypeEnum::new()->value;
        });
    }
}

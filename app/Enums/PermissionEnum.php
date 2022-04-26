<?php

namespace App\Enums;

use Illuminate\Support\Str;
use Spatie\Enum\Laravel\Enum;

/**
 * @method static self manage_users_and_roles()
 * @method static self manage_products()
 * @method static self manage_employees()
 * @method static self manage_shippings()
 * @method static self manage_order_sources()
 */
final class PermissionEnum extends Enum
{
    protected static function values()
    {
        return fn (string $name) => Str::replace('_', ' ', $name);
    }
}

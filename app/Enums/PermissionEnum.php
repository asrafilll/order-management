<?php

namespace App\Enums;

use Illuminate\Support\Str;
use Spatie\Enum\Laravel\Enum;

/**
 * @method static self manage_users_and_roles()
 * @method static self manage_products()
 */
final class PermissionEnum extends Enum
{
    protected static function values()
    {
        return fn (string $name) => Str::replace('_', ' ', $name);
    }
}

<?php

namespace App\Enums;

use Illuminate\Support\Str;
use Spatie\Enum\Laravel\Enum;

/**
 * @method static self at_warehouse()
 * @method static self on_expedition()
 * @method static self lost()
 */
class ReturnOrderStatusEnum extends Enum
{
    protected static function values()
    {
        return fn (string $name) => Str::replace(
            '_',
            ' ',
            $name
        );
    }
}

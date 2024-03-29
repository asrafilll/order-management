<?php

namespace App\Enums;

use Illuminate\Support\Str;
use Spatie\Enum\Laravel\Enum;

/**
 * @method static self waiting()
 * @method static self processed()
 * @method static self sent()
 * @method static self completed()
 * @method static self canceled()
 */
final class OrderStatusEnum extends Enum
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

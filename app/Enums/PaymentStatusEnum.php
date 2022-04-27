<?php

namespace App\Enums;

use Spatie\Enum\Laravel\Enum;

/**
 * @method static self unpaid()
 * @method static self paid()
 * @method static self credited()
 * @method static self refunded()
 */
final class PaymentStatusEnum extends Enum
{
    //
}

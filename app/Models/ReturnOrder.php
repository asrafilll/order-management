<?php

namespace App\Models;

use App\Enums\returnOrderStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'status',
    ];

    protected $casts = [
        'status' => returnOrderStatusEnum::class . ':nullable',
    ];
}

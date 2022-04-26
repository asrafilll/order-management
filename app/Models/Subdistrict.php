<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Subdistrict extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'parent',
        'name',
    ];

    public $timestamps = false;

    public function city(): BelongsTo
    {
        return $this->belongsTo(
            City::class,
            'parent',
            'code'
        );
    }

    public function villages(): HasMany
    {
        return $this->hasMany(
            Village::class,
            'parent',
            'code'
        );
    }
}

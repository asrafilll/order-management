<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class City extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'parent',
        'name',
    ];

    public $timestamps = false;

    public function province(): BelongsTo
    {
        return $this->belongsTo(
            Province::class,
            'parent',
            'code'
        );
    }

    public function subdistricts(): HasMany
    {
        return $this->hasMany(
            Subdistrict::class,
            'parent',
            'code'
        );
    }
}

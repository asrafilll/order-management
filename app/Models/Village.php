<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Village extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'parent',
        'name',
    ];

    public $timestamps = false;

    public function subdistrict(): BelongsTo
    {
        return $this->belongsTo(
            Subdistrict::class,
            'parent',
            'code'
        );
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CleaningStation extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'cleaning_zone_id',
    ];

    public function cleaningZone(): BelongsTo
    {
        return $this->belongsTo(CleaningZone::class);
    }
}

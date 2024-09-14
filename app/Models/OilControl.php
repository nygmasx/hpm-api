<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OilControl extends Model
{
    use HasFactory;

    protected $fillable = [
        "date",
        "user_id"
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function oilTrays(): BelongsToMany
    {
        return $this->belongsToMany(OilTray::class, 'oil_tray_control');
    }
}

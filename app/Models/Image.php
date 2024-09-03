<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Image extends Model
{
    use HasFactory;

    protected $fillable = ['url'];

    public function tracabilities(): BelongsToMany
    {
        return $this->belongsToMany(Tracability::class, 'image_tracability');
    }
    public function advancedTracabilities(): BelongsToMany
    {
        return $this->belongsToMany(AdvancedTracability::class, 'advanced_tracability_image');
    }
}

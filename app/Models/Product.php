<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'code'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function advancedTracabilities(): BelongsToMany
    {
        return $this->belongsToMany(AdvancedTracability::class, 'product_advanced_tracability')
            ->withPivot('expiration_date', 'quantity', 'label_picture')
            ->withTimestamps();
    }
}

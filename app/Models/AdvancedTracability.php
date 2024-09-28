<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class AdvancedTracability extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'opened_at',
        'service'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_advanced_tracability')
            ->withPivot('expiration_date', 'quantity', 'label_picture')
            ->withTimestamps();
    }

    public function images(): BelongsToMany
    {
        return $this->belongsToMany(Image::class, 'advanced_tracability_image');
    }

}

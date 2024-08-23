<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Tracability extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'opened_at',
    ];

    protected $guarded = [];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function product(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_tracability', 'tracability_id', 'product_id')
            ->withPivot('id', 'quantity', 'label_picture', 'expiration_date')->withTimestamps();
    }

    public function images(): BelongsToMany {
        return $this->belongsToMany(Image::class, 'tracability_image');
    }

}

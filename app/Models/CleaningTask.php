<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class CleaningTask extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'title',
        'estimated_time',
        'products',
        'products_quantity',
        'verification_type',
        'temperature',
        'action_time',
        'utensil',
        'rinse_type',
        'drying_type',
        'is_finished',
        'frequency',
        'cleaning_station_id'
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'users_cleaning_tasks');
    }

    public function cleaningStation(): BelongsTo
    {
        return $this->belongsTo(CleaningStation::class);
    }
}

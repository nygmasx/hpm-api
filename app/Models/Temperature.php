<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Temperature extends Model
{
    use HasFactory;

    protected $fillable = [
        'reading_date',
        'user_id'
    ];


    public function users(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function equipments(): BelongsToMany
    {
        return $this->belongsToMany(Equipment::class, 'equipment_temperature');
    }
}

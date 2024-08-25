<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Equipment extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'user_id'
    ];


    public function users(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function temperatures(): BelongsToMany{
        return $this->belongsToMany(Temperature::class, 'equipment_temperature');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Equipment extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type'
    ];

    public function temperatures(): BelongsToMany{
        return $this->belongsToMany(Temperature::class, 'equipment_temperature');
    }
}

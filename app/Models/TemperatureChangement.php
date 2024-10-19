<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class TemperatureChangement extends Model
{
    use HasFactory;

    protected $fillable = [
        'operation_type',
        'additional_informations',
        'user_id',
        'start_date',
        'start_temperature',
        'end_temperature',
        'end_date',
        'is_finished',
        'corrective_action'
    ];

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_temperature_change');
    }
}

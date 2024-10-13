<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'corrective_action'
    ];
}

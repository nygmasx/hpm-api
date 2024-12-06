<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StripeProduct extends Model
{
    /** @use HasFactory<\Database\Factories\StripeProductFactory> */
    use HasFactory;

    protected $fillable = [
        'price',
        'name',
        'stripe_product_id'
    ];
}

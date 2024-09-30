<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Reception extends Model
{
    use HasFactory;

    protected $fillable = [
        "reference",
        "date",
        "supplier_id",
        "user_id",
        "service",
        "additional_information",
        "non_compliance_reason",
        "non_compliance_picture",
    ];

    public function supplier(): BelongsTo
    {
        return $this->BelongsTo(Supplier::class);
    }

    public function user(): BelongsTo
    {
        return $this->BelongsTo(User::class);
    }

    public function products(): BelongsToMany
    {
        return $this->BelongsToMany(Product::class, 'product_reception');
    }

}

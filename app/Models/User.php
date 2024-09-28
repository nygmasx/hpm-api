<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'enterprise',
        'address',
        'phone',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function products(): HasMany
    {
        return $this->HasMany(Product::class);
    }

    public function tracabilities(): HasMany
    {
        return $this->hasMany(Tracability::class);
    }

    public function advancedTracabilities(): HasMany
    {
        return $this->hasMany(AdvancedTracability::class);
    }

    public function equipments(): HasMany
    {
        return $this->hasMany(Equipment::class);
    }

    public function temperatures(): HasMany
    {
        return $this->hasMany(Temperature::class);
    }

    public function cleaningZones(): HasMany
    {
        return $this->hasMany(CleaningZone::class);
    }

    public function cleaningPlans(): HasMany
    {
        return $this->hasMany(CleaningPlan::class);
    }

    public function oilTrays(): HasMany
    {
        return $this->hasMany(OilTray::class);
    }

    public function oilControls(): HasMany
    {
        return $this->hasMany(OilControl::class);
    }

    public function suppliers(): HasMany
    {
        return $this->hasMany(Supplier::class);
    }
}

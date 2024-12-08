<?php

namespace Database\Factories;

use App\Models\CleaningZone;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class UserCleaningZonesFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'cleaning_zone_id' => CleaningZone::factory(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    // Method to assign all zones to a specific user
    public function forUser(User $user): self
    {
        return $this->state(function (array $attributes) use ($user) {
            return [
                'user_id' => $user->id,
            ];
        });
    }

    // Method to assign all users to a specific zone
    public function forZone(CleaningZone $zone): self
    {
        return $this->state(function (array $attributes) use ($zone) {
            return [
                'cleaning_zone_id' => $zone->id,
            ];
        });
    }
}

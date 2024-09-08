<?php

namespace Database\Factories;

use App\Models\CleaningZone;
use Illuminate\Database\Eloquent\Factories\Factory;

class CleaningStationFactory extends Factory
{

    public function definition(): array
    {
        return[
            'name' => 'Poste de nettoyage '.$this->faker->unique()->randomNumber(),
            'cleaning_zone_id' => CleaningZone::factory(),
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CleaningZoneFactory extends Factory
{

    public function definition(): array
    {
        return [
            'name' => 'Zone de nettoyage ' . $this->faker->unique()->randomNumber(),
        ];
    }
}

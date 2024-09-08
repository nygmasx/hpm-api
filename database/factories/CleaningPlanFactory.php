<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CleaningPlanFactory extends Factory
{

    public function definition(): array
    {
        return [
            'date' => $this->faker->dateTime(),
            'user_id' => User::factory(),
        ];
    }
}

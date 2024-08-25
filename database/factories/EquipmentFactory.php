<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Equipment>
 */
class EquipmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => 'Equipement ' . $this->faker->numberBetween(1, 10),
            'type' => $this->faker->randomElement(['Congélateur', 'Frigo', 'Chaud']),
            'user_id' => User::factory(),
        ];
    }
}

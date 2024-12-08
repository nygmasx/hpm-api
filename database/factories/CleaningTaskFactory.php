<?php

namespace Database\Factories;

use App\Models\CleaningStation;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CleaningTask>
 */
class CleaningTaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'cleaning_station_id' => CleaningStation::factory(),
            'title' => 'Tâche '. $this->faker->randomDigit(),
            'estimated_time' => $this->faker->time('i'),
            'products' => 'Produit '. $this->faker->randomDigit(),
            'products_quantity' => $this->faker->randomDigit(),
            'verification_type' => $this->faker->randomElement(['Rincer à l\'eau claire avec une lavette', 'Rincer avec une lavette', 'Brosser', 'Frotter']),
            'frequency' => '1/jour',
        ];
    }
}

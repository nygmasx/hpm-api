<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Tracability;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductTracability>
 */
class ProductTracabilityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product_id' => Product::factory(),
            'tracability_id' => Tracability::factory(),
            'expiration_date' => $this->faker->date(),
            'quantity' => $this->faker->randomDigit(),
        ];
    }
}

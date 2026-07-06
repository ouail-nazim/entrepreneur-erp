<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->words(3, true),
            'reference' => 'REF-' . strtoupper($this->faker->unique()->bothify('??###')),
            'description' => $this->faker->sentence(),
            'unit_price' => $this->faker->randomFloat(2, 10, 500),
            'alert_threshold' => 5,
            'current_stock' => 0, // Will be updated by purchases
        ];
    }
}

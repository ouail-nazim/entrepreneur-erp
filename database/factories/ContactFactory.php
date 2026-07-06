<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Contact>
 */
class ContactFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->phoneNumber(),
            'address' => $this->faker->address(),
            'nin' => $this->faker->unique()->numerify('##########'),
            'insurance_number' => $this->faker->numerify('INS-########'),
            'hire_date' => $this->faker->date('Y-m-d', '-1 year'),
            'salary' => $this->faker->randomFloat(2, 2000, 5000),
            'photo' => null,
        ];
    }
}

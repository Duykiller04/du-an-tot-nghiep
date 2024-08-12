<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'phone' => $this->faker->phoneNumber,
            'address' => $this->faker->address, 
            'email' => $this->faker->unique()->safeEmail(),
            'age' => $this->faker->numberBetween(18, 60),
            'weight' => $this->faker->numberBetween(40, 100),
        ];
    }
}

<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CutDoseOrder>
 */
class CutDoseOrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'weight' => rand(1, 50),
            'age_min' => 1,
            'age_max' => 90,
            'gender' => fake()->boolean(),
            'name_diseases' => fake()->name(10),
        ];
    }
}

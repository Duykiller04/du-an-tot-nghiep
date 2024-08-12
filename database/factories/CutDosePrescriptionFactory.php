<?php

namespace Database\Factories;

use App\Models\Disease;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CutDosePrescription>
 */
class CutDosePrescriptionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'disease_id' => rand(1, 5),
            'name_hospital' => fake()->name(20),
            'name_doctor' => fake()->name(20),
            'age' => fake()->numberBetween(10,50),
            'phone_doctor' => fake()->phoneNumber(),
            'total' => fake()->randomFloat(2, 100, 1000),
        ];
    }
}

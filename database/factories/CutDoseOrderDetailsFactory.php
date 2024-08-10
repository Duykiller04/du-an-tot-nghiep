<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CutDoseOrderDetails>
 */
class CutDoseOrderDetailsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [

            'medicine_id' => rand(1, 10),
            'cut_dose_medication_id' => rand(1, 10),
            'medical_instruments_id' => rand(1, 10),
            'unit_id' => rand(1, 10),
            'quantity' => fake()->numberBetween(1, 100),
            'dosage' => fake()->text(50),
        ];
    }
}

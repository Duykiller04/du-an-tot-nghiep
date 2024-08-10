<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MedicalInstrument>
 */
class MedicalInstrumentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'storage_id' => rand(1,10),
            'unit_id' => rand(1,10),
            'name' => fake()->name,
            'price_import' =>fake()->numberBetween(100000,150000),
            'price_sale' =>fake()->numberBetween(150000,200000)
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\MedicalInstrument;
use App\Models\Medicine;
use App\Models\Prescription;
use App\Models\Unit;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PrescriptionDetail>
 */
class PrescriptionDetailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'medicine_id' =>  rand(1,10),
            'unit_id' =>  rand(1,10),
            'prescription_id' => rand(1,10),
            'medical_instruments_id' =>  rand(1,10),
            'quantity' => fake()->numberBetween(1, 100),
            'current_price' =>fake()->randomFloat(2, 10, 1000),
            'dosage' =>fake()->text(50),
        ];
    }
}

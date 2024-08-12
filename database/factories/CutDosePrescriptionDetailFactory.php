<?php

namespace Database\Factories;

use App\Models\CutDosePrescription;
use App\Models\MedicalInstrument;
use App\Models\Medicine;
use App\Models\Unit;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CutDosePrescriptionDetail>
 */
class CutDosePrescriptionDetailFactory extends Factory
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
            'cut_dose_prescription_id' => rand(1, 10),
            'medical_instrument_id' => rand(1, 10),
            'unit_id' => rand(1, 10),
            'quantity' => fake()->numberBetween(1, 100),
            'current_price' => fake()->randomFloat(2, 1, 100),
            'dosage' => fake()->text(50),

        ];
    }
}

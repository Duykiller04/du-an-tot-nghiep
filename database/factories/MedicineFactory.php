<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Medicine>
 */
class MedicineFactory extends Factory
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
            'unit_id'  => rand(1,10),
            'medicine_code' =>fake()->text(15),
            'price_import' =>fake()->numberBetween(100000,150000),
            'price_sale' =>fake()->numberBetween(150000,250000),
            'packaging_specification' =>fake()->text(50),
            'registration_number' =>fake()->text(15) ,
            'active_ingredient' =>fake()->text(15) ,
            'concentration' =>fake()->text(25),
            'dosage' =>fake()->text(50),
            'administration_route' =>fake()->text(15),
            'origin' => 'VietNam',
            'is_active' => true,
            'expiration_date' => date(now()),
        ];
    }
}

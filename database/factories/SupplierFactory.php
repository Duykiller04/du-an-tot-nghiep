<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Supplier>
 */
class SupplierFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
           'tax_code' =>fake()->text(10),
            'name' =>fake()->name,
            'address' =>fake()->address,
            'phone' =>fake()->phoneNumber,
            'email' =>fake()->email,
        ];
    }
}

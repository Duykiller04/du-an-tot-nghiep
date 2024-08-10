<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Prescription>
 */
class PrescriptionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'total' => fake()->randomFloat(2, 100, 10000),
            'age' => fake()->numberBetween(18, 80),
            'type_sell' => fake()->randomElement(['Bán lẻ', ' Bán giá nhập', 'Trả lại nhà cung cấp', 'Xuất','Hủy']),
            'name_customer' => fake()->name(),
        ];
    }
}

<?php

namespace Database\Seeders;

use App\Models\ImportOrderDetail;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class ImportOrderDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        foreach (range(1, 10) as $index) {
            DB::table('import_order_details')->insert([
                'import_order_id' => $faker->numberBetween(1, 10),
                'date_added' => $faker->date(),
                'quantity' => $faker->numberBetween(1, 100),
                'import_price' => fake()->randomFloat(2, 100, 1000),
                'total' => $faker->randomFloat(2, 100, 1000),
                'medicine_id' => $faker->numberBetween(1, 10),
                'unit_id' => $faker->numberBetween(1, 10),
                'note' => fake()->text(),
                'medication_name' => fake()->name(),
                'expiration_date' => $faker->date(),
                'medical_instrument_id' => $faker->numberBetween(1, 10),
            ]);
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\MedicalInstrument;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class MedicalInstrumentSupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $existingPairs = [];

        while (count($existingPairs) < 10) {
            $medicalInstrumentId = $faker->numberBetween(1, 10);
            $supplierId = $faker->numberBetween(1, 10);

            $pair = $medicalInstrumentId . '-' . $supplierId;

            if (!in_array($pair, $existingPairs)) {
                DB::table('medical_instruments_supplier')->insert([
                    'medical_instrument_id' => $medicalInstrumentId,
                    'supplier_id' => $supplierId,
                ]);
                $existingPairs[] = $pair;
            }
        }
    }
}

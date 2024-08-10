<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ExpiredMedications;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
class ExpiredMedicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        
        foreach (range(1, 10) as $index) {
            DB::table('expired_medications')->insert([
                'storage_id'=> $faker -> numberBetween(1, 10),
                'medicine_id'=> $faker -> numberBetween(1, 10),
                'medical_instrument_id'=> $faker -> numberBetween(1, 10),
                'quantity' => $faker -> numberBetween(1, 100),
                'expiration_date' => $faker->date(),
            ]);
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\Medicine;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class MedicineSupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

         for ($i=0; $i <5 ; $i++) 
         {
            DB::table('medicine_supplier')->insert([
                'medicine_id' => $faker->numberBetween(1, 10),
                'supplier_id' => $faker->numberBetween(1, 10),
            ]);
        }
    }
}

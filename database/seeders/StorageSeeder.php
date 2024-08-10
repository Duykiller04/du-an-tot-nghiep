<?php

namespace Database\Seeders;

use App\Models\Storage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
class StorageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        foreach (range(1, 10) as $index) {
            DB::table(Storage::class)->insert([
                'inventory_code' => $faker -> numberBetween(1, 10),
                'medicine_id' => $faker -> numberBetween(1, 10),
                'location' => $faker -> numberBetween(1, 10),
                'quantity'=> $faker -> numberBetween(1, 100),
                'unit_id' => $faker -> numberBetween(1, 10),
                'medical_instruments_id' => $faker -> numberBetween(1, 10),
            ]);
        }
    }
}

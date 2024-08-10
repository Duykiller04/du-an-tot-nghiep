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
            DB::table('storages')->insert([
                'inventory_code' => $faker -> numberBetween(1, 10) . $faker ->name(),
                'location' => $faker -> name(),
                'quantity'=> $faker -> numberBetween(1, 100),
                'unit_id' => $faker -> numberBetween(1, 10),
            ]);
        }
    }
}

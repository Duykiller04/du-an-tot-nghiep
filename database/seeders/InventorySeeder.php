<?php

namespace Database\Seeders;

use App\Models\Inventory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
class InventorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        
        foreach (range(1, 10) as $index) {
            DB::table(Inventory::class)->insert([
                'storage_id'=> $faker -> numberBetween(1, 10),
                'medicine_id'=> $faker -> numberBetween(1, 10),
                'quantity' => $faker -> numberBetween(1, 1000),
                'medical_instruments_id'=> $faker -> numberBetween(1, 10),
            ]);
        }
    }
}

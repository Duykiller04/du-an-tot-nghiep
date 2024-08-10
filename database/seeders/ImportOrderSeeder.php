<?php

namespace Database\Seeders;

use App\Models\ImportOrder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
class ImportOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        foreach (range(1, 10) as $index) {
            DB::table(ImportOrder::class)->insert([
                'user_id' => $faker -> numberBetween(1, 10),
                'storage_id' => $faker -> numberBetween(1, 10),
                'supplier_id' => $faker -> numberBetween(1, 10),
                'total'=> $faker -> randomFloat(2, 100, 1000),
                'price_paid' => $faker -> randomFloat(2, 100, 1000),
                'still_in_debt' => $faker -> numberBetween(1, 10),
                'date_added' => $faker->date(), // Ngày thêm
                'note' =>fake()->name(),
                'status' => $faker->randomElement(['pending', 'completed', 'canceled']), // Trạng thái
            ]);
        }
    }
}

<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\ImportOrderDetail;

use App\Models\Storage;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call(ExpiredMedicationSeeder::class);
        $this->call(InventorySeeder::class);
        $this->call(ImportOrderSeeder::class);
        $this->call(Storage::class);
        $this->call(ImportOrderDetail::class);
    }
}

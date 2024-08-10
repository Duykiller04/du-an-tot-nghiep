<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Category;
use App\Models\MedicalInstrument;
use App\Models\Medicine;
use App\Models\Supplier;
use App\Models\Unit;
use Illuminate\Database\Seeder;

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
        $this->call(EnvironmentSeeder::class);
      
        \App\Models\User::factory(10)->create();
        \App\Models\Customer::factory(10)->create();
      
        Unit::factory(5)->create();
        Category::factory(5)->create();
        Supplier::factory(10)->create();
        MedicalInstrument::factory(10)->create();
        Medicine::factory(10)->create();
    
    }
}

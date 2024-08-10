<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EnvironmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i=0; $i < 5; $i++) { 
            DB::table('environments')->insert([
                'storage_id'=>1,
                'time'=>now()->subDays(),
                'temperature'=> 35.5,
                'huminity'=> 35.5
            ]);
        }
    }
}

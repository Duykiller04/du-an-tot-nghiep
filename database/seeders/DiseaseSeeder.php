<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DiseaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i=0; $i < 5; $i++) { 
            DB::table('diseases')->insert([
                'disease_name'=>'Benh dep trai',
                'symptom'=>'nhin la nung',
                'user_id'=> 1,
                'verify_date'=> now()->subDays()
            ]);
        }
    }
}

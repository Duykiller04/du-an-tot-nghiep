<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InventoryAuditSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i=0; $i < 10; $i++) { 
            DB::table('inventory_audits')->insert([
                'storage_id'=>1,
                'user_id'=>1,
                'time'=> now()->subDays(),
                'date_recorded' => now()->subDays()
            ]);
        }
    }
}

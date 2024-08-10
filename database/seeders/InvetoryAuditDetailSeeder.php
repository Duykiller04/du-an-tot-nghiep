<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InvetoryAuditDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i=0 ; $i < 5 ; $i++ ) { 
            DB::table('inventory_check_details')->insert([
                'inventory_audit_id' => 1,
                'medicine_id' => 1,
                'medical_instrument_id' =>1,
                'quantity' => 100,
                'status' => 'checked',
            ]);
        }
    }
}

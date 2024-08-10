<?php

namespace Database\Seeders;

use App\Models\MedicalInstrument;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MedicalInstrumentSupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $medicine = MedicalInstrument::find(1);
        $supplier = [1,2,3,4];
        $medicine->suppliers()->sync($supplier);
    }
}

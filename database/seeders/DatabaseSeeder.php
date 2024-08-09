<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\CutDoseOrder;
use App\Models\CutDoseOrderDetails;
use App\Models\CutDosePrescription;
use App\Models\CutDosePrescriptionDetail;
use App\Models\Prescription;
use App\Models\PrescriptionDetail;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        CutDosePrescription::factory(10)->create();
        CutDosePrescriptionDetail::factory(10)->create();
        CutDoseOrder::factory(10)->create();
        CutDoseOrderDetails::factory(10)->create();
        Prescription::factory(10)->create();
        PrescriptionDetail::factory(10)->create();

    }
}

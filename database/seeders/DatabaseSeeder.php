<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Customer;
use App\Models\CutDoseOrder;
use App\Models\CutDoseOrderDetails;
use App\Models\CutDosePrescription;
use App\Models\CutDosePrescriptionDetail;
use App\Models\ImportOrderDetail;
use App\Models\InventoryCheckDetail;
use App\Models\Prescription;
use App\Models\PrescriptionDetail;
use App\Models\Category;
use App\Models\MedicalInstrument;
use App\Models\Medicine;
use App\Models\Storage;
use App\Models\Supplier;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();
        Unit::factory(10)->create();
        $this->call(StorageSeeder::class);
        Medicine::factory(10)->create();
        MedicalInstrument::factory(10)->create();
        Category::factory(10)->create();
        Supplier::factory(10)->create();
        $this->call(MedicineSupplierSeeder::class);
        $this->call(MedicalInstrumentSupplierSeeder::class);
        $this->call(DiseaseSeeder::class);
        CutDosePrescription::factory(10)->create();
        $this->call(ImportOrderSeeder::class);
        $this->call(ImportOrderDetailSeeder::class);
        $this->call(InventorySeeder::class);
        $this->call(ExpiredMedicationSeeder::class);
        CutDosePrescriptionDetail::factory(10)->create();
        CutDoseOrder::factory(10)->create();
        CutDoseOrderDetails::factory(10)->create();
        Customer::factory(10)->create();
        Prescription::factory(10)->create();
        PrescriptionDetail::factory(10)->create();
        $this->call(EnvironmentSeeder::class);
        $this->call(InventoryAuditSeeder::class);
        $this->call(InvetoryCheckDetailSeeder::class);
    }
}

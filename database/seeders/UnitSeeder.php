<?php

namespace Database\Seeders;

use App\Models\Unit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $find = Unit::find(1);
        $category1 = Unit::query()->create([
             'name' => 'Children 1',
             'parent_id' => $find->id,
        ]);
    }
}

<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $find = Category::find(1);
        $category1 = Category::query()->create([
                'name' => 'Children 1',
                'parent_id' => $find->id,
                'is_active' => true,
        ]);
    }
}

<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\ProductCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ProductCategory::firstOrCreate(
            ['name' => 'Uncategorized'], // Check for existence
            [
                'slug' => 'uncategorized', // Set the slug
                'status' => 1 // Set status to active (1)
            ]
        );
        Brand::firstOrCreate(
            ['name' => 'Uncategorized'], // Check for existence
            [
                'slug' => 'uncategorized', // Set the slug
                'status' => 1 // Set status to active (1)
            ]
        );
    }
}

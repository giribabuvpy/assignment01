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
        $categories = [ 
            ['id'=>1,'category_name'=>'Daily expenses'], 
            ['id'=>2,'category_name'=>'Fixed expenses'], 
            ['id'=>3,'category_name'=>'Variable expenses'],
        ];
 
        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}

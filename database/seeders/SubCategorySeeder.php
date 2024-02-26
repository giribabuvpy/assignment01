<?php

namespace Database\Seeders;

use App\Models\SubCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subCategories = [
            ['id'=>1,'category_id'=>'1','sub_category_name'=>'Title','field_type'=>'textarea','input_type'=>'string','validation'=>'required'],
            ['id'=>2,'category_id'=>'1','sub_category_name'=>'Expense Date','field_type'=>'input','input_type'=>'date','validation'=>'required'],

            ['id'=>3,'category_id'=>'2','sub_category_name'=>'Grocerry expenses','field_type'=>'input','input_type'=>'decimal','validation'=>'required'], 
            ['id'=>4,'category_id'=>'2','sub_category_name'=>'Vegitable expenses','field_type'=>'input','input_type'=>'decimal','validation'=>'optional'],
            ['id'=>5,'category_id'=>'2','sub_category_name'=>'Fruit expenses','field_type'=>'input','input_type'=>'decimal','validation'=>'optional'],
            
            ['id'=>6,'category_id'=>'3','sub_category_name'=>'School Fees','field_type'=>'input','input_type'=>'decimal','validation'=>'required'], 
            ['id'=>7,'category_id'=>'3','sub_category_name'=>'Internet charges','field_type'=>'input','input_type'=>'decimal','validation'=>'required'],
            ['id'=>8,'category_id'=>'3','sub_category_name'=>'Rent','field_type'=>'input','input_type'=>'decimal','validation'=>'required'],
        ]; 

        foreach ($subCategories as $category) {
            SubCategory::create($category);
        }
    }
}

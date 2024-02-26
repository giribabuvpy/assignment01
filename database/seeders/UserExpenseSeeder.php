<?php

namespace Database\Seeders;

use App\Models\UserExpenses;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserExpenseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userExpenses = [
            ['user_id'=>1,'sub_category_id'=>3,'data'=>'8000.00'], 
            ['user_id'=>1,'sub_category_id'=>4,'data'=>'4000.00'],
            ['user_id'=>1,'sub_category_id'=>5,'data'=>'3000.00'], 
            ['user_id'=>1,'sub_category_id'=>6,'data'=>'2000.00'],
            ['user_id'=>2,'sub_category_id'=>4,'data'=>'12500.00'], 
            ['user_id'=>2,'sub_category_id'=>5,'data'=>'5000.00'],
            ['user_id'=>2,'sub_category_id'=>6,'data'=>'6000.00'], 
            ['user_id'=>2,'sub_category_id'=>7,'data'=>'7000.00'],
        ]; 

        foreach ($userExpenses as $expenses) {
            UserExpenses::create($expenses);
        }
    }
}

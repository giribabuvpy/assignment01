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

        UserExpenses::factory()->count(15)->create();

        /* $userExpenses = [
            ['user_id'=>1,'category_id'=>2,'sub_category_id'=>3,'data'=>'8000.00','expense_date'=>date('Y-m-d')], 
            ['user_id'=>1,'category_id'=>2,'sub_category_id'=>4,'data'=>'4000.00','expense_date'=>date('Y-m-d')],
            ['user_id'=>1,'category_id'=>2,'sub_category_id'=>5,'data'=>'3000.00','expense_date'=>date('Y-m-d', strtotime("-2 days"))],
            ['user_id'=>1,'category_id'=>2,'sub_category_id'=>6,'data'=>'2000.00','expense_date'=>date('Y-m-d')],
            ['user_id'=>2,'category_id'=>2,'sub_category_id'=>4,'data'=>'1250.00','expense_date'=>date('Y-m-d')], 
            ['user_id'=>2,'category_id'=>2,'sub_category_id'=>5,'data'=>'5000.00','expense_date'=>date('Y-m-d', strtotime("-1 days"))],
            ['user_id'=>2,'category_id'=>3,'sub_category_id'=>6,'data'=>'6000.00','expense_date'=>date('Y-m-d', strtotime("-1 days"))],
            ['user_id'=>2,'category_id'=>3,'sub_category_id'=>7,'data'=>'7000.00','expense_date'=>date('Y-m-d', strtotime("-1 days"))],
            
        ];  */

        // foreach ($userExpenses as $expenses) {
        //     UserExpenses::create($expenses);
        // }
    }
}

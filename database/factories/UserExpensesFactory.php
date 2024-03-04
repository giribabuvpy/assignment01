<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\SubCategory;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserExpenses>
 */
class UserExpensesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'data' => $this->faker->randomFloat(2, 10, 1000),
            'expense_date' => $this->faker->dateTimeBetween('-1 month', '+1 month')->format('Y-m-d'),
            'user_id' => User::inRandomOrder()->first()->id,
            'category_id' => Category::inRandomOrder()->first()->id,
            'sub_category_id' => SubCategory::inRandomOrder()->first()->id,
        ];
    }
} 
<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SubCategory>
 */
class SubCategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $types = ['Grocerry','Vegitable','food', 'transport', 'housing', 'entertainment', 'utilities', 'health', 'clothing', 'education', 'other'];

        return [
            'category_id' => Category::inRandomOrder()->first()->id,
            'sub_category_name' => $this->faker->randomElement($types),
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BudgetAssignment>
 */
class BudgetAssignmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // Default to creating a new category if one isn't passed
            'category_id' => Category::factory(),

            'month' => now()->startOfMonth()->format('Y-m-d'),

            // Random between 100 and 5,000
            'amount' => $this->faker->randomFloat(2, 100, 5000),
        ];
    }
}

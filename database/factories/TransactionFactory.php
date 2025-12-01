<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            // Create a category on the fly, or set to null 30% of the time
            'category_id' => $this->faker->boolean(70)
                ? Category::factory()
                : null,

            'date' => $this->faker->dateTimeBetween('-6 months', 'now'),

            // Random amount between 10 and 5,000
            'amount' => $this->faker->randomFloat(2, 10, 5000),

            // 80% chance of having a payee
            'payee' => $this->faker->optional(0.8)->company(),

            // 60% chance of having a description
            'description' => $this->faker->optional(0.6)->sentence(),

            // 20% chance it is an inflow (income), 80% expense
            'inflow' => $this->faker->boolean(20),
        ];
    }

    /**
     * State to generate an inflow transaction specifically.
     */
    public function inflow(): static
    {
        return $this->state(fn (array $attributes) => [
            'inflow' => true,
            'category_id' => null, // Inflows usually don't have categories in some logic
        ]);
    }

    /**
     * State to generate an expense specifically.
     */
    public function expense(): static
    {
        return $this->state(fn (array $attributes) => [
            'inflow' => false,
        ]);
    }
}

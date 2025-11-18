<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'user_id' => User::factory(), // This will create a user if none exists
            // OR use an existing user: 'user_id' => User::inRandomOrder()->first()?->id,
            'is_system' => $this->faker->boolean(20),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    public function system(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_system' => true,
            'user_id' => null, // System categories typically don't have a user
        ]);
    }

    public function withoutUser(): static
    {
        return $this->state(fn (array $attributes) => [
            'user_id' => null,
        ]);
    }
}

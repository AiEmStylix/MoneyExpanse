<?php

namespace Database\Factories;

use App\Models\CategoryGroup;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    public function definition(): array
    {
        return [
            'category_group_id' => CategoryGroup::factory(),
            'name' => $this->faker->word(), // Tên danh mục ngẫu nhiên (VD: "aut")
            'order' => $this->faker->numberBetween(0, 20),
        ];
    }
}

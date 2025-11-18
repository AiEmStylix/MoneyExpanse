<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Default categories
        $categories = [
            'Lương', 'Freelance', 'Thực phẩm', 'Thuê nhà',
            'Tiện ích', 'Giao thông', 'Giải trí',
            'Ăn ngoài', 'Tiết kiệm', 'Đầu tư',
        ];

        foreach ($categories as $name) {
            Category::create([
                'name' => $name,
                'is_system' => true,
                'user_id' => null,
            ]);
        }
    }
}

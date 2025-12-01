<?php

namespace Database\Seeders;

use App\Models\BudgetAssignment;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class BudgetAssignmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Get all existing categories
        $categories = Category::all();

        // If no categories exist, create some dummy ones so the seeder works
        if ($categories->isEmpty()) {
            $categories = Category::factory(5)->create();
        }

        // 2. Define the date range (e.g., past 6 months including this one)
        $months = [];
        for ($i = 0; $i < 6; $i++) {
            $months[] = Carbon::now()->subMonths($i)->startOfMonth();
        }

        // 3. Loop through every Category AND every Month
        foreach ($categories as $category) {
            foreach ($months as $month) {

                // We check if a record exists first to prevent Unique Constraint errors
                // if you run the seeder multiple times.
                BudgetAssignment::firstOrCreate(
                    [
                        'category_id' => $category->id,
                        'month' => $month->format('Y-m-d'),
                    ],
                    [
                        'amount' => rand(100, 2000), // Override the factory amount here
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );
            }
        }
    }
}

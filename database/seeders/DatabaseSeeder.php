<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Vu Binh Duong',
            'email' => 'anhduongfa@gmail.com',
            'password' => 'duongvbna',
        ]);
        // Generate 10 random user
        User::factory(10)->create();
        $this->call([
            CategorySeeder::class,
        ]);

        // User::factory(1000)->create();
    }
}

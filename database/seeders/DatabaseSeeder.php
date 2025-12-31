<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed facilities first
        $this->call([
            FacilitySeeder::class,
            AdminUserSeeder::class,
            TestCafeSeeder::class, // Optional: comment out if you don't want test data
        ]);

        $this->command->info('✓ Database seeding completed!');
    }
}

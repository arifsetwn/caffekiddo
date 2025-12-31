<?php

namespace Database\Seeders;

use App\Models\Facility;
use Illuminate\Database\Seeder;

class FacilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $facilities = [
            ['name' => 'Playground'],
            ['name' => 'Mini Zoo'],
            ['name' => 'Highchair'],
            ['name' => 'Mainan'],
        ];

        foreach ($facilities as $facility) {
            Facility::firstOrCreate($facility);
        }

        $this->command->info('✓ Seeded 4 facilities');
    }
}

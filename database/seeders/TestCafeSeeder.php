<?php

namespace Database\Seeders;

use App\Models\Cafe;
use App\Models\Facility;
use App\Models\User;
use Illuminate\Database\Seeder;

class TestCafeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get or create a test user to be the submitter
        $user = User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => bcrypt('password'),
            ]
        );

        // Get all facilities
        $facilities = Facility::all();
        
        // Yogyakarta Cafes (5)
        $yogyakartaCafes = [
            [
                'name' => 'Kopi Klotok',
                'address' => 'Jl. Kaliurang Km 5.5, Sleman, Yogyakarta',
                'latitude' => -7.7516,
                'longitude' => 110.3981,
                'google_maps_url' => 'https://maps.google.com/?q=-7.7516,110.3981',
                'status' => 'active',
                'submitted_by' => $user->id,
                'facilities' => [1, 3], // Playground, Highchair
            ],
            [
                'name' => 'Cafe Anak Riang',
                'address' => 'Jl. Gejayan No. 15, Sleman, Yogyakarta',
                'latitude' => -7.7746,
                'longitude' => 110.3816,
                'google_maps_url' => 'https://maps.google.com/?q=-7.7746,110.3816',
                'status' => 'active',
                'submitted_by' => $user->id,
                'facilities' => [1, 2, 4], // Playground, Mini Zoo, Mainan
            ],
            [
                'name' => 'Kedai Bocah',
                'address' => 'Jl. Seturan Raya No. 22, Sleman, Yogyakarta',
                'latitude' => -7.7502,
                'longitude' => 110.4075,
                'google_maps_url' => 'https://maps.google.com/?q=-7.7502,110.4075',
                'status' => 'active',
                'submitted_by' => $user->id,
                'facilities' => [1, 3, 4], // Playground, Highchair, Mainan
            ],
            [
                'name' => 'Taman Sari Kids Cafe',
                'address' => 'Jl. Taman Siswa No. 5, Yogyakarta',
                'latitude' => -7.8120,
                'longitude' => 110.3632,
                'google_maps_url' => 'https://maps.google.com/?q=-7.8120,110.3632',
                'status' => 'active',
                'submitted_by' => $user->id,
                'facilities' => [1, 2, 3], // Playground, Mini Zoo, Highchair
            ],
            [
                'name' => 'Warung Keluarga Bahagia',
                'address' => 'Jl. Palagan Tentara Pelajar Km 7, Sleman, Yogyakarta',
                'latitude' => -7.7315,
                'longitude' => 110.3875,
                'google_maps_url' => 'https://maps.google.com/?q=-7.7315,110.3875',
                'status' => 'active',
                'submitted_by' => $user->id,
                'facilities' => [3, 4], // Highchair, Mainan
            ],
        ];

        // Solo/Surakarta Cafes (5)
        $soloCafes = [
            [
                'name' => 'Cafe Anak Ceria Solo',
                'address' => 'Jl. Slamet Riyadi No. 125, Surakarta',
                'latitude' => -7.5661,
                'longitude' => 110.8168,
                'google_maps_url' => 'https://maps.google.com/?q=-7.5661,110.8168',
                'status' => 'active',
                'submitted_by' => $user->id,
                'facilities' => [1, 4], // Playground, Mainan
            ],
            [
                'name' => 'Taman Bermain Cafe',
                'address' => 'Jl. Ir. Sutami No. 36, Surakarta',
                'latitude' => -7.5587,
                'longitude' => 110.8507,
                'google_maps_url' => 'https://maps.google.com/?q=-7.5587,110.8507',
                'status' => 'active',
                'submitted_by' => $user->id,
                'facilities' => [1, 2, 3, 4], // All facilities
            ],
            [
                'name' => 'Kedai Keluarga Solo',
                'address' => 'Jl. Adisucipto No. 88, Surakarta',
                'latitude' => -7.5187,
                'longitude' => 110.7674,
                'google_maps_url' => 'https://maps.google.com/?q=-7.5187,110.7674',
                'status' => 'active',
                'submitted_by' => $user->id,
                'facilities' => [1, 3], // Playground, Highchair
            ],
            [
                'name' => 'Rumah Makan Bayi & Balita',
                'address' => 'Jl. Veteran No. 45, Surakarta',
                'latitude' => -7.5715,
                'longitude' => 110.8252,
                'google_maps_url' => 'https://maps.google.com/?q=-7.5715,110.8252',
                'status' => 'active',
                'submitted_by' => $user->id,
                'facilities' => [3, 4], // Highchair, Mainan
            ],
            [
                'name' => 'Sangkuriang Kids Corner',
                'address' => 'Jl. Brigjend Slamet Riyadi No. 261, Surakarta',
                'latitude' => -7.5613,
                'longitude' => 110.7999,
                'google_maps_url' => 'https://maps.google.com/?q=-7.5613,110.7999',
                'status' => 'active',
                'submitted_by' => $user->id,
                'facilities' => [1, 2, 4], // Playground, Mini Zoo, Mainan
            ],
        ];

        // Seed Yogyakarta cafes
        foreach ($yogyakartaCafes as $cafeData) {
            $facilityIds = $cafeData['facilities'];
            unset($cafeData['facilities']);
            
            $cafe = Cafe::create($cafeData);
            $cafe->facilities()->attach($facilityIds);
        }

        // Seed Solo cafes
        foreach ($soloCafes as $cafeData) {
            $facilityIds = $cafeData['facilities'];
            unset($cafeData['facilities']);
            
            $cafe = Cafe::create($cafeData);
            $cafe->facilities()->attach($facilityIds);
        }

        $this->command->info('✓ Created 10 test cafes (5 in Yogyakarta, 5 in Solo)');
    }
}

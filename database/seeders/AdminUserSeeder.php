<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@cafekiddo.com'],
            [
                'name' => 'Admin CafeKiddo',
                'password' => Hash::make('password'),
                'is_admin' => true,
            ]
        );

        $this->command->info('✓ Created admin user (admin@cafekiddo.com)');
    }
}

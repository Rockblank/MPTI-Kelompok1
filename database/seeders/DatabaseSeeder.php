<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        if (app()->environment(['local', 'testing'])) {
            User::firstOrCreate(
                ['email' => 'test@example.com'],
                ['name' => 'Test User', 'password' => Hash::make('password')]
            );
        }

        if (app()->environment('local')) {
            User::firstOrCreate(
                ['email' => 'bendahara@bem-filkom.ub.ac.id'],
                [
                    'name' => 'Demo Bendahara',
                    'password' => Hash::make('bendahara123'),
                    'role' => 'bendahara',
                ]
            );
        }
    }
}

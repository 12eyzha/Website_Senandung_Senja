<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Seeder user (biarin, ga masalah)
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@senandung.test',
            'password' => 'password',
        ]);

        // 🔥 PENTING
        $this->call([
            EmployeeSeeder::class,
            CategorySeeder::class,
            MenuSeeder::class,
        ]);
    }
}

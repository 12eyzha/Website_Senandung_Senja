<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,      // ⬅️ ADMIN DIPINDAH KE SINI
            EmployeeSeeder::class,
            CategorySeeder::class,
            MenuSeeder::class,
        ]);
    }
}

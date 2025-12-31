<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Employee;

class EmployeeSeeder extends Seeder
{
    public function run(): void
    {
        Employee::create([
            'name' => 'Admin Senandung',
            'email' => 'admin@senandung.test',
            'password' => 'password',
            'position' => 'admin',
            'status' => 'active',
        ]);
    }
}

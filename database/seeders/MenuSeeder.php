<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Menu;

class MenuSeeder extends Seeder
{
    public function run()
    {
        Menu::create([
            'name' => 'Americano',
            'description' => 'Kopi hitam',
            'price' => 18000,
            'category_id' => 1,
            'is_available' => true,
        ]);
    }
}

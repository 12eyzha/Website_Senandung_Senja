<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Menu;

class MenuSeeder extends Seeder
{
    public function run()
{
    $menus = [

        /* ================= ☕ COFFEE (1) ================= */
        ['name'=>'Americano','description'=>'Kopi hitam klasik','price'=>18000,'category_id'=>1,'is_available'=>true],
        ['name'=>'Espresso','description'=>'Kopi pekat dengan crema','price'=>17000,'category_id'=>1,'is_available'=>true],
        ['name'=>'Double Espresso','description'=>'Espresso double shot','price'=>22000,'category_id'=>1,'is_available'=>true],
        ['name'=>'Cappuccino','description'=>'Espresso dengan susu dan foam','price'=>25000,'category_id'=>1,'is_available'=>true],
        ['name'=>'Cafe Latte','description'=>'Kopi susu lembut','price'=>26000,'category_id'=>1,'is_available'=>true],
        ['name'=>'Vanilla Latte','description'=>'Latte dengan vanilla','price'=>28000,'category_id'=>1,'is_available'=>true],
        ['name'=>'Caramel Latte','description'=>'Latte rasa karamel','price'=>29000,'category_id'=>1,'is_available'=>true],
        ['name'=>'Hazelnut Latte','description'=>'Latte rasa hazelnut','price'=>29000,'category_id'=>1,'is_available'=>true],
        ['name'=>'Mocha','description'=>'Kopi coklat','price'=>28000,'category_id'=>1,'is_available'=>true],
        ['name'=>'Affogato','description'=>'Espresso dengan es krim','price'=>32000,'category_id'=>1,'is_available'=>true],
        ['name'=>'Cold Brew','description'=>'Kopi seduh dingin','price'=>24000,'category_id'=>1,'is_available'=>true],
        ['name'=>'Kopi Susu Senja','description'=>'Signature kopi susu','price'=>23000,'category_id'=>1,'is_available'=>true],

        /* ================= 🧋 NON COFFEE (2) ================= */
        ['name'=>'Matcha Latte','description'=>'Matcha creamy','price'=>28000,'category_id'=>2,'is_available'=>true],
        ['name'=>'Matcha Frappe','description'=>'Matcha dingin blend','price'=>30000,'category_id'=>2,'is_available'=>true],
        ['name'=>'Chocolate','description'=>'Coklat panas/dingin','price'=>26000,'category_id'=>2,'is_available'=>true],
        ['name'=>'Chocolate Frappe','description'=>'Coklat blend','price'=>29000,'category_id'=>2,'is_available'=>true],
        ['name'=>'Red Velvet','description'=>'Minuman red velvet','price'=>27000,'category_id'=>2,'is_available'=>true],
        ['name'=>'Thai Tea','description'=>'Thai tea creamy','price'=>25000,'category_id'=>2,'is_available'=>true],
        ['name'=>'Green Tea','description'=>'Teh hijau segar','price'=>22000,'category_id'=>2,'is_available'=>true],
        ['name'=>'Lemon Tea','description'=>'Teh lemon segar','price'=>22000,'category_id'=>2,'is_available'=>true],
        ['name'=>'Lychee Tea','description'=>'Teh leci segar','price'=>24000,'category_id'=>2,'is_available'=>true],
        ['name'=>'Peach Tea','description'=>'Teh peach','price'=>24000,'category_id'=>2,'is_available'=>true],
        ['name'=>'Mineral Water','description'=>'Air mineral','price'=>10000,'category_id'=>2,'is_available'=>true],

        /* ================= 🍽️ FOOD (3) ================= */
        ['name'=>'Butter Croissant','description'=>'Croissant mentega','price'=>22000,'category_id'=>3,'is_available'=>true],
        ['name'=>'Chocolate Croissant','description'=>'Croissant coklat','price'=>25000,'category_id'=>3,'is_available'=>true],
        ['name'=>'Cheese Croissant','description'=>'Croissant keju','price'=>26000,'category_id'=>3,'is_available'=>true],
        ['name'=>'French Fries','description'=>'Kentang goreng','price'=>20000,'category_id'=>3,'is_available'=>true],
        ['name'=>'Chicken Wings','description'=>'Sayap ayam crispy','price'=>32000,'category_id'=>3,'is_available'=>true],
        ['name'=>'Chicken Sandwich','description'=>'Sandwich ayam','price'=>35000,'category_id'=>3,'is_available'=>true],
        ['name'=>'Beef Sandwich','description'=>'Sandwich daging sapi','price'=>38000,'category_id'=>3,'is_available'=>true],
        ['name'=>'Chicken Rice Bowl','description'=>'Nasi ayam crispy','price'=>35000,'category_id'=>3,'is_available'=>true],
        ['name'=>'Beef Rice Bowl','description'=>'Nasi daging sapi','price'=>38000,'category_id'=>3,'is_available'=>true],
        ['name'=>'Spaghetti Carbonara','description'=>'Pasta creamy','price'=>42000,'category_id'=>3,'is_available'=>true],
        ['name'=>'Spaghetti Bolognese','description'=>'Pasta saus daging','price'=>42000,'category_id'=>3,'is_available'=>true],
        ['name'=>'Toast Chocolate','description'=>'Roti bakar coklat','price'=>20000,'category_id'=>3,'is_available'=>true],
        ['name'=>'Toast Cheese','description'=>'Roti bakar keju','price'=>22000,'category_id'=>3,'is_available'=>true],
    ];

    foreach ($menus as $menu) {
        Menu::updateOrCreate(
            ['name' => $menu['name']],
            $menu
        );
    }
}

}
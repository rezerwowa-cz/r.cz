<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;

class Categories extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = ['Fryzjer', 'Dentysta', 'Auto', 'Krawiectwo', 'Korepetycje'];

        foreach ($categories as $category) {
            Category::create(['name' => $category]);
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            'Conciertos',
            'Festivales',
            'Lanzamientos',
            'Overtune',
            'Recomendaciones',
            'Entrevistas'
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(['category' => $category]);
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\Recipe;
use Illuminate\Database\Seeder;

class RecipeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $recipes = [
            'vue salad',
            'react salad',
            'angular salad',
            'php chicken',
            'python beef',
            'node fish'
        ];

        foreach ($recipes as $recipe) {
            Recipe::create(['name' => $recipe]);
        }
    }
}
